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
require 'log_novedades/log_novedades.php';

//Se valida la existencia de una variable para controlar el envio de los correos
if (isset($_GET["disparador_envio"])) {

    //Comparacion de las llaves de envio
    if ($_GET["disparador_envio"] === "000000809008362") {

        require '../PHPMailer/src/Exception.php';
        require '../PHPMailer/src/PHPMailer.php';
        require '../PHPMailer/src/SMTP.php';

        //Clase de consultas
        require_once '../modelos/ReporteMipres.php';

        //Funciones que crean los archivos planos
        require 'crear_archivos.php';

        //Constantes de parametros de envio email
        require '../config/global_email.php';

        //Instancia a la clase urgencias
        $reporte = new ReporteMipres();


################################################################################
################################################################################
################################################################################
#################      ARMADO PRESCRIPCIONES AÑO 2022      #####################


        $consulta_direccionamiento = $reporte->get_direccionamientos('2022-01-01', '2022-12-31');
        $data_direccionamientos = array();
        $sum_reg_dir = 0;

        while ($respuesta = sqlsrv_fetch_object($consulta_direccionamiento)) {

            $tr = "<tr>"
                    . "<td style='text-align: center'>" . $respuesta->TIPOIDPROV . "</td> "
                    . "<td style='text-align: center'>" . $respuesta->NOIDPROV . "</td> "
                    . "<td style='text-align: justify'>" . $respuesta->NOMPROV . "</td> "
                    . "<td style='text-align: center'>" . $respuesta->T_SIN_REPORTE . "</td> "
                    . "</tr>";

            $sum_reg_dir = $sum_reg_dir + $respuesta->T_SIN_REPORTE;
            array_push($data_direccionamientos, $tr);
        }

        $archivo_direccionamientos = ($data_direccionamientos) ? generar_arc_direccionamientos22($reporte->get_data_direccionamientos('2022-01-01', '2022-12-31')) : '0';

################################################################################
################################################################################
################################################################################
#############    ARMADO PRESCRIPCIONES AÑO 2022 CON URG Y HOSP    ##############


        $consulta_direUH = $reporte->get_direUH('2022-01-01', '2022-12-31');
        $data_direUH = array();
        $sum_reg_dirUH = 0;

        while ($respuesta = sqlsrv_fetch_object($consulta_direUH)) {

            $tr = "<tr>"
                    . "<td style='text-align: center'>" . $respuesta->TIPOIDIPS . "</td> "
                    . "<td style='text-align: center'>" . $respuesta->NROIDIPS . "</td> "
                    . "<td style='text-align: justify'>" . $respuesta->NOMIDIPS . "</td> "
                    . "<td style='text-align: center'>" . $respuesta->T_SIN_REPORTE . "</td> "
                    . "</tr>";

            $sum_reg_dirUH = $sum_reg_dirUH + $respuesta->T_SIN_REPORTE;
            array_push($data_direUH, $tr);
        }


        $archivo_direccionamientosUH = ($data_direUH) ? generar_arc_direUH22($reporte->get_data_direUH('2022-01-01', '2022-12-31')) : '0';


################################################################################
################################################################################
################################################################################
################################################################################
###################  COMPRUEBO SI HAY DATOS PARA ENVIAR   ######################
        if (count($data_direccionamientos) > 0) {


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
                //Recipients
                $mail->setFrom(MAIL_REMITENTE, 'Pijaos Salud EPS-I');

		// cambio adicion correos 14-10-2022

		$mail->addAddress(COR_RECOBROS);                              
                $mail->addAddress(AUX_RECOBROS);                              
                $mail->addAddress(COR_CM);                             
                $mail->addAddress(COR_AUTORIZACIONES);                             
                $mail->addAddress(COR_GYC);                             
                $mail->addAddress(MIPRES);
                //$mail->addBCC(AUX_DESA1);          
                $mail->addBCC(AUX_DESA2);                                 
                $mail->addBCC(COR_DESARROLLO);                              
                $mail->addBCC(COR_AUTORIZACIONES2);
                $mail->addCC(CONTROL_INTERNO2);
                $mail->addCC(MIPRES);
                $mail->addBCC(AUX_DESA3);
                $mail->addBCC(COR_DESARROLLO2);

                ($archivo_direccionamientos !== '0') ? $mail->addAttachment($archivo_direccionamientos) : "";
                ($archivo_direccionamientosUH !== '0') ? $mail->addAttachment($archivo_direccionamientosUH) : "";


                $tabla_msg = "<p style='text-align: justify'> "
                        . "Consolidado registros MIPRES de la vigencia 2022 con fecha m&aacute;xima de entrega menor a la actual y sin "
                        . "reporte de entrega por parte del proveedor de servicios."
                        . "</p>"
                        . "<table border='1' cellspacing='0' cellpadding='2' style='width: 50%;'> "
                        . "<thead> "
                        . "<tr> "
                        . "<th colspan='4' style='background-color: #e1edd7'>Prescripciones Vigencia 2022 - (Se excluyen servicios con &aacute;mbito hospitalizaci&oacute;n y urgencias) </th> "
                        . "</tr> "
                        . " <tr> "
                        . "<th style='background-color: #e1edd7'>Tip_ident.</th> "
                        . "<th style='background-color: #e1edd7'>Num_ident.</th> "
                        . "<th style='background-color: #e1edd7'>Nom_prestador</th> "
                        . "<th style='background-color: #e1edd7'>Total registros</th> "
                        . "</tr> "
                        . "</thead> "
                        . "<tbody>"
                        . "" . implode($data_direccionamientos) . ""
                        . "<tr>"
                        . "<th style='background-color: #e1edd7' colspan='3'> Sumatoria Registros </th> "
                        . "<th style='background-color: #e1edd7'>" . $sum_reg_dir . "</th> "
                        . "</tr>"
                        . "</tbody> "
                        . "</table> "
                        . "<table border='1' cellspacing='0' cellpadding='2' style='width: 50%; margin-top: 25px;'> "
                        . "<thead> "
                        . "<tr> "
                        . "<th colspan='4' style='background-color: #e1edd7'>Prescripciones Vigencia 2022 - Trazabilidad solo Urgencias y Hospitalizaci&oacute;n</th> "
                        . "</tr> "
                        . " <tr> "
                        . "<th style='background-color: #e1edd7'>Tip_ident.</th> "
                        . "<th style='background-color: #e1edd7'>Num_ident.</th> "
                        . "<th style='background-color: #e1edd7'>Nom_prestador</th> "
                        . "<th style='background-color: #e1edd7'>Total registros</th> "
                        . "</tr> "
                        . "</thead> "
                        . "<tbody>"
                        . "" . implode($data_direUH) . ""
                        . "<tr>"
                        . "<th style='background-color: #e1edd7' colspan='3'> Sumatoria Registros </th> "
                        . "<th style='background-color: #e1edd7'>" . $sum_reg_dirUH . "</th> "
                        . "</tr>"
                        . "</tbody> "
                        . "</table> "
                        . "<p style='text-align: justify'>  "
                        . "*** Correo generado de forma autom&aacute;tica, por favor no responder. Si tiene alguna duda o se presenta alguna inconsitencia en la "
                        . "informaci&oacute;n aqu&iacute; suministrada consulte con el &aacute;rea de Desarrollo de Software.  *** "
                        . "</p> ";


                //Content
                $mail->isHTML(true);                                        //Set email format to HTML
                $mail->Subject = utf8_decode("Notificacion Diaria - Registros MIPRES sin reporte de entrega vigencia 2022");
                $mail->Body = utf8_decode($tabla_msg);

                $mail->send();

                //Borrado de los ficheros
                (file_exists($archivo_direccionamientos)) ? unlink($archivo_direccionamientos) : "";
                (file_exists($archivo_direccionamientosUH)) ? unlink($archivo_direccionamientosUH) : "";

                //echo 'Mensaje enviado con exito!!!';
                log_txt('log_mipres22.txt', "Mensaje enviado con exito!!!");
            } catch (Exception $e) {

                //Borrado de los ficheros
                (file_exists($archivo_direccionamientos)) ? unlink($archivo_direccionamientos) : "";
                (file_exists($archivo_direccionamientosUH)) ? unlink($archivo_direccionamientosUH) : "";

                //echo "Error al enviar el mensaje: {$mail->ErrorInfo}";
                log_txt('log_mipres22.txt', "Error al enviar el mensaje: {$mail->ErrorInfo}");
            }
        } else {

            //echo 'No hay resultados para exportar';
            log_txt('log_mipres22.txt', "No hay resultados para exportar");
        }
    } else {

        log_txt('log_mipres22.txt', utf8_encode('Llave de verificacion invalida. Consulte con el administrador de la aplicacion'));
        echo utf8_encode('Llave de verificacion invalida. Consulte con el administrador de la aplicacion');
    }
} else {

    log_txt('log_mipres22.txt', utf8_encode('Recurso inaccesible, tarea programada en el servidor 192.168.20.240'));
    echo utf8_encode('Recurso inaccesible, tarea programada en el servidor 192.168.20.240');
}
