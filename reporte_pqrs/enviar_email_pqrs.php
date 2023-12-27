<?php
//  #####################################
//  #####################################
//  #########  ENVIO DE EMAILS ##########
//  ######### PQRSF DE LA EPSI ##########
//  #####################################

//Envio de correos
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Log de errores
//require 'log_novedades/log_novedades_lb.php';


  require '../PHPMailer/src/Exception.php';
  require '../PHPMailer/src/PHPMailer.php';
  require '../PHPMailer/src/SMTP.php';

  //Constantes de parametros de envio email
  require '../config/global_email.php';
  //Funciones que crean los archivos planos
  require 'crear_archivos.php';
  //Clase de consultas
  require_once '../modelos/ReportePqrs.php';
  //instancia de la clase pqrs
  $pqrs =  new ReportePqrs();

  //Creamos las variable de la pqrs
  $result = $pqrs->getPqrsEmail();

  $correopersona = $result->CORREOEMAIL;
  $pqrsf = $result->COD_AREA_REF;
  $pnombre = $result->PRI_NOMBRE;
  $snombre = $result->SEG_NOMBRE;
  $papellido = $result->PRI_APELLIDO;
  $sapellido = $result->SEG_APELLIDO;
  $consecutivo = $result->CONSECUTIVO;
  $tpdocumento = $result->TP_DOC_AFI;
  $documento = $result->NM_DOC_AFI;
  $telefono = $result->TELEFONO .'  '.$result->CELULAR1;
  $correo = $result->CORREOEMAIL;
  $descripcion = $result->DETALLE;
  //Iniciamos con la instancia del correo
  $mail = new PHPMailer(true);
  //Configuracion del servidor SMTP
  $mail->SMTPDebug = 0;                                       //Enable verbose debug output
  $mail->isSMTP();                                            //Send using SMTP
  $mail->Host = 'smtp.gmail.com';                             //Set the SMTP server to send through
  $mail->SMTPAuth = true;                                     //Enable SMTP authentication
  $mail->Username = MAIL_REMITENTE;                           //SMTP username
  $mail->Password = decrypt(MAIL_PASSWORD);                   //SMTP password
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
  $mail->Port = 587;                                          //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
  $mail->CharSet = "utf-8";
  //Recipiente
  $mail->setFrom(MAIL_REMITENTE, 'Notificación de PQRS');
  $mail->addAddress(SIAU);
  $mail->addCC($correopersona);
  $mail->addCC(AUX_DESA2);
  // 14-10-2022 cambio adicion de correos
  $mail->addCC(AUX_DESA3);
  $mail->addCC(COR_DESARROLLO2);
  $mail->addCC(CONTROL_INTERNO);
  $mail->addCC(CONTROL_INTERNO2);
  $mail->addCC(COR_GYC);

  $mensaje  =  '<div class="container-border" style=" border: 2px solid #2332CE;width: 700px !important;margin-left: 400px;padding: 10px;border-radius: 20px;z-index: 10;">
  <div class="container-fluid color-blue" style="border-radius: 10px;background-color: #2332CE !important;"><br><br><br><br></div><br><br>
  <div class="container center" style="margin-left: 40px;">
  <img src="https://saludmadreymujer.com/archivos/img/logo.png" width="90px" height="90px" style="margin-left: 250px ;">
  <br>
  <br>
  <p>¿Como vas?</p>
  <p>Te contamos que recibimos una solicitud de PQRSF '.$pqrsf.'</p>
  <p>Expuesta para la EPSI o/y IPS con los siguientes datos.</p>
  </div>
  <div class="container" style="margin-left: 40px;">
  <h4>PQRS EXPUESTA POR EL USUARIO<span> '.$pnombre.' '.$snombre.' '.$papellido . ' '.$sapellido.'</span> </h4>
  <h5>NUMERO DE RADICADO: '.$consecutivo.'</h5>
  <h5>TIPO DE DOCUMENTO: '.$tpdocumento.'</h5>
  <h5>NUMERO DE DOCUMENTO: '.$documento.'</h5>
  <h5>NUMERO TELEFONICO: '.$telefono.'</h5>
  <h5>CORREO ELECTRONICO: '.$correo.' </h5>
  </div>
  <div class="container" style=" padding-left: 40px;" width="200px;" >
  <h3>MENSAJE</h3>
  <P> '.$descripcion.'</P>
  </div>
  <div class="container">
  <img src="https://saludmadreymujer.com/archivos/img/pqrs.png" width="400px;">
  </div>
  <div class="container-fluid color-blue" style="border-radius: 10px;">
  <br><br><br><br>
  </div>
  </div> ';
  $mail->isHTML(true);                                        //Set email format to HTML
  $mail->Subject = utf8_decode('Notificacion de PQRS Pijaos Salud EPSI');
  $mail->Body = utf8_decode($mensaje);
  $mail->send();
  $pqrs->actualizarQuejaEnvio($consecutivo);

