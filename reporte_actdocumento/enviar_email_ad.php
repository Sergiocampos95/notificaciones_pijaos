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
require 'log_novedades/log_novedades_ad.php';


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
        require_once '../modelos/ReporteActDocumento.php';
        //Instancia a la clase urgencias
        $reporte = new ReporteActDocumento();

################################################################################
################################################################################
################################################################################
#######################  ARMADO INFORME AUTORIZACION   #########################

        $consulta_afiliados = $reporte->get_resumenTP();
        $data_tipodoc = Array();
        $sum_reg = 0;

        while ($respuesta = sqlsrv_fetch_object($consulta_afiliados)) {

            $tr = "<tr>"
                    . "<td style='text-align: center'>" . $respuesta->TIP_DOCUMENTO_BEN . "</td> "
                    . "<td style='text-align: center'>" . $respuesta->TOTAL_REGISTROS . "</td> "
                    . "</tr>";

            $sum_reg = $sum_reg + $respuesta->TOTAL_REGISTROS;
            array_push($data_tipodoc, $tr);
        }
################################################################################
################################################################################
################################################################################
################################################################################
###################  COMPRUEBO SI HAY DATOS PARA ENVIAR   ######################


        if (count($data_tipodoc) > 0) {

            //Archivo CN
            $data_CN = get_afiliados($reporte->get_dataTP(1));
            $archivo_CN = ($data_CN) ? generar_data($data_CN, 1) : '0';
            
            
            //Archivo RC
            $data_RC = get_afiliados($reporte->get_dataTP(2));
            $archivo_RC = ($data_RC) ? generar_data($data_RC, 2) : '0';
            
            
            //Archivo TI
            $data_TI = get_afiliados($reporte->get_dataTP(3));
            $archivo_TI = ($data_TI) ? generar_data($data_TI, 3) : '0';


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

         	// adicion correo 14-10-2022
		$mail->addAddress(GESTION_AFILIADOS);
                $mail->addCC(COR_ASEGURAMIENTO);
                $mail->addBCC(COR_DESARROLLO);
                $mail->addBCC(AUX_DESA1);
                $mail->addBCC(ADM_BDUA);
                $mail->addBCC(CONTROL_INTERNO);
                $mail->addBCC(CONTROL_INTERNO2);
                $mail->addBCC(COR_DESARROLLO2);
                $mail->addBCC(AUX_DESA3);

                //Attachments
                ($archivo_CN !== '0') ? $mail->addAttachment($archivo_CN) : "";
                ($archivo_RC !== '0') ? $mail->addAttachment($archivo_RC) : "";
                ($archivo_TI !== '0') ? $mail->addAttachment($archivo_TI) : "";


                $tabla_msg = "<p style='text-align: justify'> "
                        . "Registros de afiliados activos en la base de datos con tipo de documento desactualizado seg&uacute;n la fecha de nacimiento "
                        . "registrada en el sistema de informaci&oacute;n."
                        . "</p>"
                        . "<table border='1' cellspacing='0' cellpadding='2' style='width: 30%;'> "
                        . "<thead> "
                        . "<tr> "
                        . "<th colspan='2' style='background-color: #e1edd7'> Documentos pendientes por actualizar </th> "
                        . "</tr> "
                        . " <tr> "
                        . "<th style='background-color: #e1edd7'>Tipo documento</th> "
                        . "<th style='background-color: #e1edd7'>Total registros</th> "
                        . "</tr> "
                        . "</thead> "
                        . "<tbody>"
                        . "" . implode($data_tipodoc) . ""
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
                $mail->Subject = utf8_decode('Afiliados con tipo de documento pendiente por actualizar - Corte al ' . date('d-m-Y'));
                //$mail->Body = utf8_decode($tabla_msg);
                $mail->Body = utf8_decode($tabla_msg);

                $mail->send();

                //Borrado de los ficheros
                (file_exists($archivo_CN)) ? unlink($archivo_CN) : "";
                (file_exists($archivo_RC)) ? unlink($archivo_RC) : "";
                (file_exists($archivo_TI)) ? unlink($archivo_TI) : "";

                //echo 'Mensaje enviado con exito!!!';
                log_txt("Mensaje enviado con exito!!!");
            } catch (Exception $e) {

                //Borrado de los ficheros
                (file_exists($archivo_CN)) ? unlink($archivo_CN) : "";
                (file_exists($archivo_RC)) ? unlink($archivo_RC) : "";
                (file_exists($archivo_TI)) ? unlink($archivo_TI) : "";

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












    





