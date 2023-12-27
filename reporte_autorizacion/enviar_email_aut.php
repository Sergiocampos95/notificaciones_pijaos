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

        require '../PHPMailer/src/Exception.php';
        require '../PHPMailer/src/PHPMailer.php';
        require '../PHPMailer/src/SMTP.php';


        //Constantes de parametros de envio email
        require '../config/global_email.php';

        //Funciones que crean los archivos planos
        require 'crear_archivos.php';

        //Clase de consultas
        require_once '../modelos/ReporteAutorizacion.php';
        //Instancia a la clase urgencias
        $reporte = new ReporteAutorizacion();

################################################################################
################################################################################
################################################################################
#######################  ARMADO INFORME AUTORIZACION   #########################

        $consulta_aut = $reporte->get_resumen_aut();
        $data_aut = Array();
        $sum_reg = 0;

        while ($respuesta = sqlsrv_fetch_object($consulta_aut)) {

            $tr = "<tr>"
                    . "<td style='text-align: center'>" . $respuesta->VIGENCIA . "</td> "
                    . "<td style='text-align: center'>" . $respuesta->TOTAL_REGISTROS . "</td> "
                    . "</tr>";

            $sum_reg = $sum_reg + $respuesta->TOTAL_REGISTROS;
            array_push($data_aut, $tr);
        }

################################################################################
################################################################################
################################################################################
################################################################################
###################  COMPRUEBO SI HAY DATOS PARA ENVIAR   ######################


        if ($data_aut > 0) {

            $archivo_agrupado = generar_agrupado($reporte->get_autorizaciones());
            $arc_arupado_ant  = generar_agrupadoAnt($reporte->get_autorAnt());
            $archivo_aut      = generar_sabana($reporte->get_data_autorizaciones());

            ///////////////////////// GENERAR COMPRIMIDO ///////////////////////
            //Añadir archivos al comprimido
            $addarchivos = array();

            //Creamos el array y declaramos los ficheros de la carpeta
            $addarchivos = array(
                $archivo_aut,
                $archivo_agrupado,
                $arc_arupado_ant
            );

            //Declaramos el nombre del archivo comprimido
            $nombre_zip = 'log_arc_enviados/aut_cobro' . date('d-m-Y') . '.zip';

            //Instanciamos la clase ZipArchive
            $mizip = new ZipArchive();
            $mizip->open($nombre_zip, ZipArchive::CREATE);


            //Agregamos los archivos a comprimir
            foreach ($addarchivos as $nuevo) {

                //Crear el comprimido con los archivos seleccionados
                $mizip->addFile($nuevo, str_replace('log_arc_enviados/', '', $nuevo));
            }

            $mizip->close();

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
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
                $mail->Port = 587;                                          //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                $mail->CharSet = "utf-8";
                //Recipients
                $mail->setFrom(MAIL_REMITENTE, 'Pijaos Salud EPS-I');

           	// adicion correos 14-10-2022
		$mail->addAddress(CONT_SEGUIMIENTO3);
                $mail->addAddress(CONT_SEGUIMIENTO4);
                $mail->addAddress(AUDM_VILLAVO);
                $mail->addBCC(COR_DESARROLLO);
                $mail->addBCC(AUX_DESA1);
                $mail->addBCC(COR_AUTORIZACIONES);
                $mail->addBCC(COR_GYC);
                $mail->addBCC(COR_AUTORIZACIONES2);
                $mail->addBCC(CONTROL_INTERNO);
                $mail->addBCC(CONTROL_INTERNO2);
                $mail->addBCC(COR_DESARROLLO2);
                $mail->addBCC(AUX_DESA3);

                //Attachments
                (isset($nombre_zip)) ? $mail->addAttachment($nombre_zip) : "";


                $tabla_msg = "<p style='text-align: justify'> "
                        . "Consolidado de autorizaciones pendientes de cobro de la vigencia 2016 hasta la fecha."
                        . "</p>"
                        . "<table border='1' cellspacing='0' cellpadding='2' style='width: 50%;'> "
                        . "<thead> "
                        . "<tr> "
                        . "<th colspan='2' style='background-color: #e1edd7'> Autorizaciones Vigencia 2021  - (Periodo 2016 hasta la fecha) </th> "
                        . "</tr> "
                        . " <tr> "
                        . "<th style='background-color: #e1edd7'>Vigencia</th> "
                        . "<th style='background-color: #e1edd7'>Total registros</th> "
                        . "</tr> "
                        . "</thead> "
                        . "<tbody>"
                        . "" . implode($data_aut) . ""
                        . "<tr>"
                        . "<th style='background-color: #e1edd7'> Sumatoria Registros </th> "
                        . "<th style='background-color: #e1edd7'>" . $sum_reg . "</th> "
                        . "</tr>"
                        . "</tbody> "
                        . "</table> "
                        . "<p style='text-align: justify'>  "
                        . "*** Correo generado de forma autom&aacute;tica, por favor no responder. Si tiene alguna duda o se presenta alguna inconsitencia en la "
                        . "informaci&oacute;n aqu&iacute; suministrada consulte con el &aacute;rea de Desarrollo de Software.  *** "
                        . "</p> ";


                //Content
                $mail->isHTML(true);                                        //Set email format to HTML
                $mail->Subject = utf8_decode('Autorizaciones pendientes de cobro - Corte al ' . date('d-m-Y'));
                //$mail->Body = utf8_decode($tabla_msg);
                $mail->Body = utf8_decode($tabla_msg);

                $mail->send();

                //Borrado de los ficheros
                (file_exists($archivo_agrupado)) ? unlink($archivo_agrupado) : "";
                (file_exists($arc_arupado_ant)) ? unlink($arc_arupado_ant) : "";
                (file_exists($archivo_aut)) ? unlink($archivo_aut) : "";
                (file_exists($nombre_zip)) ? unlink($nombre_zip) : "";

                //echo 'Mensaje enviado con exito!!!';
                log_txt("Mensaje enviado con exito!!!");
            } catch (Exception $e) {

                //Borrado de los ficheros
                (file_exists($archivo_agrupado)) ? unlink($archivo_agrupado) : "";
                (file_exists($arc_arupado_ant)) ? unlink($arc_arupado_ant) : "";
                (file_exists($archivo_aut)) ? unlink($archivo_aut) : "";
                (file_exists($nombre_zip)) ? unlink($nombre_zip) : "";

                //echo "Error al enviar el mensaje: {$mail->ErrorInfo}";
                log_txt("Error al enviar el mensaje: {$mail->ErrorInfo}");
            }
        } else {

            //echo 'No hay resultados para exportar';
            log_txt("No hay resultados para exportar");
        }
    } else {

        log_txt(utf8_encode('Llave de verificacion invalida. Consulte con el administrador de la aplicacion'));
        echo utf8_encode('Llave de verificacion invalida. Consulte con el administrador de la aplicacion');
    }
} else {

    log_txt(utf8_encode('Recurso inaccesible, tarea programada en el servidor 192.168.20.240'));
    echo utf8_encode('Recurso inaccesible, tarea programada en el servidor 192.168.20.240');
}












    





