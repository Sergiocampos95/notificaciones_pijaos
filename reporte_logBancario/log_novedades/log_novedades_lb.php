<?php

////////////////////////////////////////////////////////////////////////////////
/////////////////////////       SISTEMA GEMA_WEB       /////////////////////////
/////////////////////////      PIJAOS SALUD EPSI      //////////////////////////
//////////////////////    LOG NOVEDADES ENVIO CORREOS   ////////////////////////
/////////////////////////  DEPARTAMENTO DE DESARROLLO  /////////////////////////
///////                 LOG DE NOVEDADES - ENVIOS EMAILS              //////////
////////////////////////////////////////////////////////////////////////////////
//zona horaria colombia
date_default_timezone_set("America/Bogota");

/**
 * Metodo que guarda el log de novedades en el proceso cron tab
 * @param String $mensaje
 */
function log_txt($mensaje) {

    $file = fopen("log_novedades/log_env_lb.txt", "a");

    if ($file) {

        fwrite($file, '- ' . $mensaje . ' ' . date('m-d-Y h:i:s a', time()) . PHP_EOL);
        fclose($file);
    } else {

        echo 'No se abrio el archivo';
    }
}
