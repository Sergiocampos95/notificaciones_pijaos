<?php
////////////////////////////////////////////////////////////////////////////////
/////////////////////////       SISTEMA GEMA_WEB       /////////////////////////
/////////////////////////      PIJAOS SALUD EPSI      //////////////////////////
//////////////////////       CREACION DE FICHEROS TXT   ////////////////////////
/////////////////////////  DEPARTAMENTO DE DESARROLLO  /////////////////////////
////////////////////////////////////////////////////////////////////////////////
//si no existe la funcion de consulta, la definimos
if (!function_exists('generar_log')) {
  /**
  * Metodo que genera un archivo plano con la agrupacion de autorizaciones
  * por prestador
  * @param obj $reporte_agrupado
  * @return string
  */
  function generar_log($reporte_agrupado) {
    $archivo_agrupado = "log_arc_enviados/log_bancario.txt";
    //Apertura del archivo plano
    $file = fopen($archivo_agrupado, "w");
    //Encabezado del archivo
    fwrite($file,
      'RBE_ID_CONSEC|' .
      'RBE_ID_REGISTRO|' .
      'RBE_FEC_RECAUDO|' .
      'RBE_COD_RECEPTORA|' .
      'RBE_NIT_ADMIN|' .
      'RBE_NOMBRE_ADMIN|' .
      'RBE_RESERVADO|' .
      'RBE_NOM_ARCHIVO|' .
      'RBE_FEC_CARGUE|' .
      'RBE_USU_CARGUE|' .
      'RBD_ID_CONSEC|' .
      'RBD_ID_REGISTRO|' .
      'RBD_ID_APORTANTE|' .
      'RBD_NOM_APORTANTE|' .
      'RBD_COD_BANCO|' .
      'RBD_NRO_PLANILLA|' .
      'RBD_PERIODO_PAGO|' .
      'RBD_CANAL_PAGO|' .
      'RBD_NRO_REGISTROS|' .
      'RBD_COD_OPERADOR|' .
      'RBD_VALOR_PLANILLA|' .
      'RBD_HORA_MINUTO|' .
      'RBD_NRO_SECUENCIA|' .
      'RBD_APO_IDEMPRESA|' .
      'RBD_RESERVADO|' .
      'RBD_NRO_ERROR|' .
      'RBD_ESTADO|' .
      'EAP_ID_CONSEC_PILA' .
      PHP_EOL
    );
      while ($final = sqlsrv_fetch_object($reporte_agrupado)) {
        fwrite($file,
          $final->RBE_ID_CONSEC . '|' .
          $final->RBE_ID_REGISTRO . '|' .
          $final->RBE_FEC_RECAUDO . '|' .
          $final->RBE_COD_RECEPTORA . '|' .
          $final->RBE_NIT_ADMIN . '|' .
          $final->RBE_NOMBRE_ADMIN . '|' .
          $final->RBE_RESERVADO . '|' .
          $final->RBE_NOM_ARCHIVO . '|' .
          $final->RBE_FEC_CARGUE . '|' .
          $final->RBE_USU_CARGUE . '|' .
          $final->RBD_ID_CONSEC . '|' .
          $final->RBD_ID_REGISTRO . '|' .
          $final->RBD_ID_APORTANTE . '|' .
          $final->RBD_NOM_APORTANTE . '|' .
          $final->RBD_COD_BANCO . '|' .
          $final->RBD_NRO_PLANILLA . '|' .
          $final->RBD_PERIODO_PAGO . '|' .
          $final->RBD_CANAL_PAGO . '|' .
          $final->RBD_NRO_REGISTROS . '|' .
          $final->RBD_COD_OPERADOR . '|' .
          $final->RBD_VALOR_PLANILLA . '|' .
          $final->RBD_HORA_MINUTO . '|' .
          $final->RBD_NRO_SECUENCIA . '|' .
          $final->RBD_APO_IDEMPRESA . '|' .
          $final->RBD_RESERVADO . '|' .
          $final->RBD_NRO_ERROR . '|' .
          $final->RBD_ESTADO . '|' .
          $final->EAP_ID_CONSEC_PILA .
          PHP_EOL
        );
      }
      //Cierre del archivo
      fclose($file);
      return $archivo_agrupado;
  }
}
