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
require 'log_novedades/log_novedades_fallecidos.php';
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
    require_once '../modelos/ReporteFallecidos.php';
    //Instancia a la clase urgencias
    $reporte = new ReporteFallecidos();
################################################################################
################################################################################
################################################################################
#########################  ARMADO INFORME URGENCIAS   ##########################
    $data_urgencias = get_fall_urgencia($reporte->get_fa_urgencias());
    $archivo_urgencias = ($data_urgencias) ? generar_arc_urgencias($data_urgencias) : '0';
################################################################################
################################################################################
################################################################################
######################  ARMADO INFORME HOSPITALIZACION   #######################
    $data_hospitalizacion = get_fall_hospitalizacion($reporte->get_fa_hospitalizaciones());
    $archivo_hospitalizacion = ($data_hospitalizacion) ? generar_arc_hospitalizacion($data_hospitalizacion) : '0';
################################################################################
################################################################################
################################################################################
#################  ARMADO INFORME FALLECIDOS FACTURACION   #####################
    $data_facturacion = get_fall_facturacion($reporte->get_fallecidos_facturacion());
    $archivo_facturacion = ($data_facturacion) ? generar_arc_facturacion($data_facturacion) : '0';
################################################################################
################################################################################
################################################################################
################################################################################
###################  COMPRUEBO SI HAY DATOS PARA ENVIAR   ######################
  if (count($data_urgencias) > 0 || count($data_hospitalizacion) > 0 || count($data_facturacion > 0)) {
  //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
  try {
    //Server settings
    $mail->SMTPDebug = 0;                                       //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host = 'smtp.gmail.com';                             //Set the SMTP server to send through
    $mail->SMTPAuth = true;                                     //Enable SMTP authentication
    $mail->Username = MAIL_REMITENTE;                           //SMTP username
    $mail->Password = decrypt(MAIL_PASSWORD);         //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port = 587;                                          //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->CharSet = "utf-8";
    //Recipients
    $mail->setFrom(MAIL_REMITENTE, 'Pijaos Salud EPS-I');
    // adicion correos 14-10-2022

    $mail->addAddress(GESTION_AFILIADOS);
    $mail->addAddress(COR_ASEGURAMIENTO);
    $mail->addBCC(COR_DESARROLLO);
    $mail->addBCC(AUX_DESA1);
    $mail->addBCC(CONTROL_INTERNO);
    $mail->addBCC(CONTROL_INTERNO2);
    $mail->addBCC(COR_ASEGURAMIENTO);
    $mail->addBCC(ADM_BDUA);
    $mail->addBCC(CONTROL_INTERNO3);
    $mail->addBCC(AUX_DESA3);
    
    //Attachments
    ($archivo_urgencias !== '0') ? $mail->addAttachment($archivo_urgencias) : "";
    ($archivo_hospitalizacion !== '0') ? $mail->addAttachment($archivo_hospitalizacion) : "";
    ($archivo_facturacion !== '0') ? $mail->addAttachment($archivo_facturacion) : "";

    $tabla_msg = "<p style='text-align: justify'> "
      . "Consolidado de afiliados activos en la base de datos de la EPS-I, reportados como fallecidos desde el &aacute;rea de cuentas "
      . "m&eacute;dicas y/o notificados v&iacute;a RIPS con causa b&aacute;sica de muerte en los archivos de Urgencias y Hospitalizaciones."
      . "</p>"
      . "<table border='1' cellspacing='0' cellpadding='2'> "
      . "<tr> "
      . "<th style='width: 200px; background-color: #e1edd7'>Fallecidos por RIPS</th> "
      . "<th style='width: 100px; background-color: #e1edd7'>N. registros</th> "
      . "</tr> "
      . "<tr> "
      . "<th style='text-align: left'>Arch. Urgencias</th> "
      . "<td style='text-align: center'>" . count($data_urgencias) . "</td> "
      . "</tr> "
      . "<tr> "
      . "<th style='text-align: left'>Arch. Hospitalizaciones</th> "
      . "<td style='text-align: center'>" . count($data_hospitalizacion) . "</td> "
      . "</tr> "
      . "</table>"
      . "<table border='1' cellspacing='0' cellpadding='2' style='margin-top: 25px;'> "
      . "<tr> "
      . "<th colspan='2' style='background-color: #e1edd7'>Fallecidos por facturaci&oacute;n</th> "
      . "</tr> "
      . "<tr> "
      . "<th style='text-align: left; width: 200px'>Total registros</th> "
      . "<td style='text-align: center; width: 100px'>" . count($data_facturacion) . "</td> "
      . "</tr> "
      . "</table> "
      . "<p style='text-align: justify'>  "
      . "*** Correo generado de forma autom&aacute;tica, por favor no responder. Si tiene alguna duda o se presenta alguna inconsitencia en la "
      . "informaci&oacute;n aqu&iacute; suministrada consulte con el &aacute;rea de Desarrollo de Software.  *** "
      . "</p> ";
    //Content
      $mail->isHTML(true);                                        //Set email format to HTML
      $mail->Subject = utf8_decode('Afiliados reportados como fallecidos - Corte al ' . date('d-m-Y'));
      $mail->Body = utf8_decode($tabla_msg);
      $mail->send();
      //Borrado de los ficheros
      (file_exists($archivo_urgencias)) ? unlink($archivo_urgencias) : "";
      (file_exists($archivo_hospitalizacion)) ? unlink($archivo_hospitalizacion) : "";
      (file_exists($archivo_facturacion)) ? unlink($archivo_facturacion) : "";
      //echo 'Mensaje enviado con exito!!!';
      log_txt("Mensaje enviado con exito!!!");
  } catch (Exception $e) {
    //Borrado de los ficheros
    (file_exists($archivo_urgencias)) ? unlink($archivo_urgencias) : "";
    (file_exists($archivo_hospitalizacion)) ? unlink($archivo_hospitalizacion) : "";
    (file_exists($archivo_facturacion)) ? unlink($archivo_facturacion) : "";
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