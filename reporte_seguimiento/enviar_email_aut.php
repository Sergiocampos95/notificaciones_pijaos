<?php

////////////////////////////////////////////////////////////////////////////////
/////////////////////////       SISTEMA GEMA_WEB       /////////////////////////
/////////////////////////      PIJAOS SALUD EPSI      //////////////////////////
////////////////////      ENVIO DEL CORREO ELECTRONICO  ////////////////////////
/////////////////////////  DEPARTAMENTO DE DESARROLLO  /////////////////////////
////////////////////////////////////////////////////////////////////////////////
/**
* Pijaos Salud EPS Indígena – TIC 04/03/2024
*Envio de correos con la notificacion de las autorizaciones de oxigeno proximas 
*a vencer. La notificacion se realiza dos meses antes de que se venza, se crea 
*solicitud por medio del ticket 1474. MROJAS
**/
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Log de errores
require 'log_novedades/log_novedades_aut.php';

//Añade la libreria phpmailer
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

//Constantes de parametros de envio email
require '../config/global_email.php';

//Funciones que crean los archivos planos
require 'crear_archivos.php';

//Clase de consultas
require_once '../modelos/ReporteAutorizacion.php';

//Se valida la existencia de una variable para controlar el envio de los correos
if (isset($_GET["disparador_envio"])) {

    //Comparacion de las llaves de envio
    if ($_GET["disparador_envio"] === "000000809008362") {
                
        ################################################################################
        ################################################################################
        ################################################################################
        ##########       INFORME AUTORIZACIONES OXIGENO  #########################

        //Instancia la clase autorizaciones
        $reporte = new ReporteAutorizacion();
        // Consulta las autorizaciones relacionadas con seguimiento de  oxigeno
        $consulta_aut = $reporte->get_autorizaciones_seguimiento_oxigeno();

        // Variable que almacena la cantidad de registros
        $data = 0;

        //ciclo que calcula la cantidad de registros
        while ($respuesta = sqlsrv_fetch_object($consulta_aut)) {
            $data = $data + $respuesta->TOTAL_REGISTROS;
        }

        //valida si hay registros para enviar
        if ($data > 0) {
            //Instancia a la clase ReporteAutorizacion
            $reporte = new ReporteAutorizacion();
            //Consulta los prestadores que tienen autorizaciones en estado NP
            $consulta_aut = $reporte->get_autorizaciones_seguimiento_oxigeno();
            //Variable que almacena la cantidad de registros
            $sum_reg = 0;
            //Variable que almacena la tabla de autorizaciones
            $data_aut = Array();
                //ciclo que recorre las autorizaciones y guarda la estructura en un array
                while ($respuesta = sqlsrv_fetch_object($consulta_aut)) {
                    // Asigno el valor de las fechas a una variable
                    $fechaAutorizacion = $respuesta->FEC_AUTORIZA;
                    $fechaVencimiento = $respuesta->FEC_VENCIMIENTO;
                    // Formatear la fecha y la hora
                    $fechaAutorizacionFormateada = $fechaAutorizacion->format('Y-m-d');
                    $fechaAutorizacionVencimiento = $fechaVencimiento->format('Y-m-d');
                    // Armo la tabla de autorizaciones
                    $tr = "<tr>"
                            . "<td style='text-align: center'>" . $respuesta->NO_AUTORIZACION . "</td> "
                            . "<td style='text-align: center'>" . $respuesta->NO_SOLICITUD . "</td> "
                            . "<td style='text-align: center'>" . $fechaAutorizacionFormateada . "</td> "
                            . "<td style='text-align: center'>" . $fechaAutorizacionVencimiento . "</td> "
                            . "</tr>";
                    //sumo la cantidad de registros
                    $sum_reg = $sum_reg + $respuesta->TOTAL_REGISTROS;
                    array_push($data_aut, $tr);
                }
                ################################################################################
                ################################################################################
                ################################################################################
                ######################       ANEXAR ARCHIVO          #########################
                $archivo_agrupado = generar_agrupado($reporte->get_autorizaciones_seguimiento_oxigeno());
                ///////////////////////// GENERAR COMPRIMIDO ///////////////////////
                //Añadir archivos al comprimido
                $addarchivos = array();

                //Creamos el array y declaramos los ficheros de la carpeta
                $addarchivos = array(
                    $archivo_agrupado
                );

                //Declaramos el nombre del archivo comprimido
                $nombre_zip = 'log_arc_enviados/aut_casos_oxigeno_' . date('d-m-Y') . '.zip';

                //Instanciamos la clase ZipArchive
                $mizip = new ZipArchive();
                $mizip->open($nombre_zip, ZipArchive::CREATE);

                //Agregamos los archivos a comprimir
                foreach ($addarchivos as $nuevo) {
                    //Crear el comprimido con los archivos seleccionados
                    $mizip->addFile($nuevo, str_replace('log_arc_enviados/', '', $nuevo));
                }

                $mizip->close();
                ################################################################################
                ################################################################################
                ################################################################################
                ######################       ENVIO DE CORREO           #########################
                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);
                try {
                    //Server settings
                    $mail->SMTPDebug = 0;                                       //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host = 'smtp.gmail.com';                             //Set the SMTP server to send through
                    $mail->SMTPAuth = true;                                     //Enable SMTP authentication
                    $mail->Username = MAIL_REMITENTE;                           //SMTP username
                    $mail->Password = decrypt(MAIL_PASSWORD);                   //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable implicit TLS encryption
                    $mail->Port = 587;                                          //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                    $mail->CharSet = "utf-8";
                    //Recipients
                    $mail->setFrom(MAIL_REMITENTE, 'Pijaos Salud EPS-I');

                    $mail->addAddress("laura.hernandez@pijaossalud.com.co");
                    $mail->addAddress("altocosto@pijaossalud.com.co ");
                    //$mail->addAddress("analistaderequerimientos@pijaossalud.com.co");
                    $mail->addBCC(AUX_DESA1);
                    $mail->addBCC(AUX_DESA3);

                    //Adjuntos
                    (isset($nombre_zip)) ? $mail->addAttachment($nombre_zip) : "";

                    //contenido del correo
                    $tabla_msg = 
                    "<p style='text-align: justify'> "
                    . "Cordial saludo, "
                    . "</p>"
                    . "<p style='text-align: justify'> "
                    . "Este correo tiene como propósito informar a las partes interesadas sobre los casos de oxígeno que  <br>"
                    . "están próximos a vencer en nuestro sistema, así como aquellos casos cuya vigencia ya ha expirado <br>"
                    . "pero que aún se encuentran abiertos."
                    . "</p>"
                    . "<p style='text-align: justify'> "
                    . 'Por favor, revisa esta información y toma las medidas necesarias para garantizar la continuidad y atención oportuna de estos casos.'
                    . "</p>"
                    . "<tr> "
                    . "<table border='1' cellspacing='0' cellpadding='2' style='width: 50%;'> "
                    . "<thead> "
                    . "<tr> "
                    . "<th colspan='4' style='background-color: #e1edd7'> Autorizaciones próximas a vencer </th> "
                    . "</tr> "
                    . " <tr> "
                    . "<th style='background-color: #e1edd7'>No Autorizacion</th> "
                    . "<th style='background-color: #e1edd7'>No solicitud</th> "
                    . "<th style='background-color: #e1edd7'>Fecha autorizacion</th> "
                    . "<th style='background-color: #e1edd7'>Fecha vencimiento</th> "
                    . "</tr> "
                    . "</thead> "
                    . "<tbody>"
                    . "" . implode($data_aut) . ""
                    . "<tr>"
                    . "<th colspan='3' style='background-color: #e1edd7'> Cantidad de autorizaciones </th> "
                    . "<th colspan='1' style='background-color: #e1edd7'>" . $sum_reg . "</th> "
                    . "</tr>"
                    . "</tbody> "
                    . "</table> "
                    . "<p style='text-align: justify'>  "
                    . "*** Correo generado de forma autom&aacute;tica, por favor no responder. Si tiene alguna duda o se presenta alguna inconsitencia en la "
                    . "informaci&oacute;n aqu&iacute; suministrada consulte con el &aacute;rea de Desarrollo de Software.  *** "
                    . "</p> ";

                    //Encabezado del correo
                    $mail->isHTML(true);                                        //Set email format to HTML
                    $mail->Subject = utf8_decode('Notificación casos de oxígeno ' . date('d-m-Y'));
                    //$mail->Body = utf8_decode($tabla_msg);
                    $mail->Body = utf8_decode($tabla_msg);

                    //envia el correo
                    $mail->send();

                    //agrega log de envio de correo
                    log_txt("Mensaje enviado con exito!!!");
                    
                } catch (Exception $e) {
                    //agragar log de error
                    log_txt("Error al enviar el mensaje: {$mail->ErrorInfo}");
                }
        }else{
            log_txt("No hay registros para enviar");
        }

    } else {
        //agragar log de error
        log_txt(utf8_encode('Llave de verificacion invalida. Consulte con el administrador de la aplicacion'));
        echo utf8_encode('Llave de verificacion invalida. Consulte con el administrador de la aplicacion');
    }
} else {
    log_txt(utf8_encode('Recurso inaccesible, tarea programada en el servidor 192.168.20.240'));
    echo utf8_encode('Recurso inaccesible, tarea programada en el servidor 192.168.20.240');
}












    





