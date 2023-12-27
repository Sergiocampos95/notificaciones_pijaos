<?php

////////////////////////////////////////////////////////////////////////////////
/////////////////////////       SISTEMA GEMA_WEB       /////////////////////////
/////////////////////////      PIJAOS SALUD EPSI      //////////////////////////
////////////////////      ENVIO DEL CORREO ELECTRONICO  ////////////////////////
/////////////////////////  DEPARTAMENTO DE DESARROLLO  /////////////////////////
////////////////////////////////////////////////////////////////////////////////
//Envio de correos
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Log de errores
require 'log_novedades/log_novedades_aut.php';

//Se valida la existencia de una variable para controlar el envio de los correos
if (isset($_GET["disparador_envio"])) {

    //Comparacion de las llaves de envio
    if ($_GET["disparador_envio"] === "000000809008362") {
                
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

        ################################################################################
        ################################################################################
        ################################################################################
        ##########       INFORME AUTORIZACIONES EN ESTADO NP  #########################

            //Instancia la clase autorizaciones
            $reporte = new ReporteAutorizacion();
            // Consulta las autorizaciones en estado NP
            $consulta_aut = $reporte->get_autorizaciones_estado_NP();

            // Variable que almacena la cantidad de registros
            $data = 0;

            //ciclo que calcula la cantidad de registros
            while ($respuesta = sqlsrv_fetch_object($consulta_aut)) {
                $data = $data + $respuesta->TOTAL_REGISTROS;
            }

            //valida si hay registros para enviar
            if ($data > 0) {
                $correos = Array();
                $sum_correos = 0;
                //Instancia a la clase ReporteAutorizacion
                $reporte = new ReporteAutorizacion();
                //Consulta los prestadores que tienen autorizaciones en estado NP
                $consulta_prestadores = $reporte->get_prestadores_aut_estado_NP();
                //ciclo que recorre los prestadores
                while ($respuesta = sqlsrv_fetch_object($consulta_prestadores)) {
                    //Variable que almacena la cantidad de registros
                    $sum_reg = 0;
                    //Variable que almacena la tabla de autorizaciones
                    $data_aut = Array();
                    //Instancia a la clase ReporteAutorizacion
                    $reporte = new ReporteAutorizacion();
                    //Consulta las autorizaciones en estado NP por prestador
                    $consulta_aut_por_prestador = $reporte->get_aut_por_prestador_estado_NP($respuesta->NIT_PRESTADOR);
                    //ciclo que recorre las autorizaciones
                    while ($respuesta2 = sqlsrv_fetch_object($consulta_aut_por_prestador)) {
                        // Asigno el valor de las fechas a una variable
                        $fechaAutorizacion = $respuesta2->FEC_AUTORIZA;
                        $fechaVencimiento = $respuesta2->FEC_VENCIMIENTO;
                        // Formatear la fecha y la hora
                        $fechaAutorizacionFormateada = $fechaAutorizacion->format('Y-m-d');
                        $fechaAutorizacionVencimiento = $fechaVencimiento->format('Y-m-d');
                        // Armo la tabla de autorizaciones
                        $tr = "<tr>"
                                . "<td style='text-align: center'>" . $respuesta2->NO_SOLICITUD . "</td> "
                                . "<td style='text-align: center'>" . $respuesta2->NO_AUTORIZACION . "</td> "
                                . "<td style='text-align: center'>" . $fechaAutorizacionFormateada . "</td> "
                                . "<td style='text-align: center'>" . $fechaAutorizacionVencimiento . "</td> "
                                . "</tr>";
                        //sumo la cantidad de registros
                        $sum_reg = $sum_reg + $respuesta2->TOTAL_REGISTROS;
                        array_push($data_aut, $tr);
                    }
                    ################################################################################
                    ################################################################################
                    ################################################################################
                    ######################       ANEXAR ARCHIVO          #########################
                    $archivo_agrupado = generar_agrupado($reporte->get_aut_por_prestador_estado_NP($respuesta->NIT_PRESTADOR));

                    ///////////////////////// GENERAR COMPRIMIDO ///////////////////////
                    //Añadir archivos al comprimido
                    $addarchivos = array();

                    //Creamos el array y declaramos los ficheros de la carpeta
                    $addarchivos = array(
                        $archivo_agrupado
                    );

                    //Declaramos el nombre del archivo comprimido
                    $nombre_zip = 'log_arc_enviados/aut_vencidas_' . date('d-m-Y') . '.zip';

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

                        // $prueba = 1; variable de pruebas, descomentar para enviar a un correo especifico

                        // valida si el correo electronico del prestador esta vacio
                        if (isset($respuesta->COR_ELECTRONICO)) {
                        // if ($prueba == 1) {, descomentar para enviar a un correo especifico

                            // si no esta vacion adiciona el correo
                            $mail->addAddress($respuesta->COR_ELECTRONICO);
                            // $mail->addAddress("correo_de_pruebas@pijaossalud.com.co");
                            $mail->addBCC(AUX_DESA1);
                            $mail->addBCC(AUX_DESA3);

                            //Adjuntos
                            (isset($nombre_zip)) ? $mail->addAttachment($nombre_zip) : "";

                            //contenido del correo
                            $tabla_msg = "<p style='text-align: justify'> "
                            . "Estimado/a " . $respuesta->NOM_PRESTADOR
                            . "</p>"
                            . "<p style='text-align: justify'> "
                            . "Cordial saludo, "
                            . "</p>"
                            . "<p style='text-align: justify'> "
                            . "Pijaos Salud EPSI, se permite enviar relación de las autorizaciones generadas en los últimos 5 meses en estado NO PRESTADA. <br>"
                            . "Dichas autorizaciones afectan de manera directa la reserva técnica de la EPS, así como la información de prestación efectiva de los servicios de salud, que debe ser reportada a los entes de control, bajo el marco de la<br>"
                            . "sentencia T760."
                            . "</p>"
                            . "<p style='text-align: justify'> "
                            . 'Agradecemos remitir al correo electrónico enfermeragyc@pijaossalud.com.co, archivo adjunto con columna adicional "por facturar" o "Anular", según corresponda.'
                            . "</p>"
                            . "<p style='text-align: justify'> "
                            . 'Plazo de envío, 30 días calendario posterior a la emisión del presente comunicado, para las reportadas como "Anular", o ante la no respuesta por parte de ustedes, la EPSI se procederá a dar de baja en nuestro sistema de <br>'
                            . 'información las autorizaciones contempladas en dichas vigencias, cerrando así el ciclo de la autorización, la cual queda inhabilitada para cobro. <br>'
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
                            $mail->Subject = utf8_decode('Recordatorio de Vencimiento de Autorizaciones Médicas ' . date('d-m-Y'));
                            //$mail->Body = utf8_decode($tabla_msg);
                            $mail->Body = utf8_decode($tabla_msg);

                            //envia el correo
                            $mail->send();

                            //agrega log de envio de correo
                            log_txt("Mensaje enviado con exito!!!");
                        } else {
                            // si esta vacio adiciona el prestador a la lista de prestadores sin correo
                            $info_prestadores = "";
                            $info_prestadores .= "<tr>"
                                    . "<td style='text-align: center'>" . $respuesta->NOM_PRESTADOR . "</td> "
                                    . "<td style='text-align: center'>" . $respuesta->NIT_PRESTADOR . "</td> "
                                    . "</tr>";
                            array_push($correos, $info_prestadores);
                            // suma la cantidad de prestadores sin correo
                            $sum_correos = $sum_correos + 1;
                        };
                    } catch (Exception $e) {
                        //agragar log de error
                        log_txt("Error al enviar el mensaje: {$mail->ErrorInfo}");
                    }
                }
            } else {
                //echo 'No hay resultados para exportar';
                log_txt("No hay resultados para exportar");
            }

            ################################################################################
            ################################################################################
            ################################################################################
            ###################### ENVIO DE CORREO CON PRESTORES SIN CORREO ################
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
                
                // envia el correo electronico a el area de contratacion
                $mail->addAddress(CONT_SEGUIMIENTO4);
                $mail->addAddress(CONT_SEGUIMIENTO3);
                // $mail->addAddress("correo_de_pruebas@pijaossalud.com.co");
                $mail->addBCC(AUX_DESA1);
                $mail->addBCC(AUX_DESA3);

                //contenido del correo
                $tabla_msg = "<p style='text-align: justify'> "
                . "Estimados Contratacion" 
                . "</p>"
                . "<p style='text-align: justify'> "
                . "Cordial saludo, "
                . "</p>"
                . "<p style='text-align: justify'> "
                . "Se realiza el envio con el consolidado de prestadores los cuales No cuentan con correo registrado y por esto no recibieron la notificacion de las autorizaciones pendientes por gestionar <br>"
                . "</p>"
                . "<p style='text-align: justify'> "
                . "Por favor dar gestion y actualizar la informacion de los prestadores. <br>"
                . "</p>"
                . "<tr> "
                . "<table border='1' cellspacing='0' cellpadding='2' style='width: 50%;'> "
                . "<thead> "
                . "<tr> "
                . "<th colspan='3' style='background-color: #e1edd7'> Prestadores </th> "
                . "</tr> "
                . " <tr> "
                . "<th style='background-color: #e1edd7'>Nombre prestador</th> "
                . "<th style='background-color: #e1edd7'>Nit prestador</th> "
                . "</tr> "
                . "</thead> "
                . "<tbody>"
                . "" . implode($correos) . ""
                . "<tr>"
                . "<th colspan='1' style='background-color: #e1edd7'> Total de prestadores </th> "
                . "<th colspan='1' style='background-color: #e1edd7'>" . $sum_correos . "</th> "
                . "</tr>"
                . "</tbody> "
                . "</table> "
                . "<p style='text-align: justify'>  "
                . "*** Correo generado de forma autom&aacute;tica, por favor no responder. Si tiene alguna duda o se presenta alguna inconsitencia en la "
                . "informaci&oacute;n aqu&iacute; suministrada consulte con el &aacute;rea de Desarrollo de Software.  *** "
                . "</p> ";

                //Encabezado del correo
                $mail->isHTML(true);                                        //Set email format to HTML
                $mail->Subject = utf8_decode('Prestadores sin correo de contacto ' . date('d-m-Y'));
                //$mail->Body = utf8_decode($tabla_msg);
                $mail->Body = utf8_decode($tabla_msg);

                //envia el correo
                $mail->send();

                //agrega log de envio de correo
                log_txt("Mensaje (consolidado prestadores) enviado con exito!!!");

            } catch (Exception $e) {
                //agragar log de error
                log_txt("Error al enviar el mensaje (consolidado prestadores): {$mail->ErrorInfo}");
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












    





