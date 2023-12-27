<?php

////////////////////////////////////////////////////////////////////////////////
/////////////////////////       SISTEMA GEMA_WEB       /////////////////////////
/////////////////////////      PIJAOS SALUD EPSI      //////////////////////////
//////////////////////       CREACION DE FICHEROS TXT   ////////////////////////
/////////////////////////  DEPARTAMENTO DE DESARROLLO  /////////////////////////
////////////////////////////////////////////////////////////////////////////////
//si no existe la funcion de consulta, la definimos
if (!function_exists('generar_agrupado')) {


    /**
     * Metodo que genera un archivo plano con la agrupacion de autorizaciones
     * por prestador
     * @param obj $reporte_agrupado
     * @return string
     */
    function generar_agrupado($reporte_agrupado) {

        $archivo_agrupado = "log_arc_enviados/agrupado_prestadores.txt";

        //Apertura del archivo plano
        $file = fopen($archivo_agrupado, "w");

        //Encabezado del archivo
        fwrite($file,
                'NR_IDENT_PREST_IPS|' .
                'NOM_PRESTADOR|' .
                'TOTAL_REGISTROS' .
                PHP_EOL);

        while ($final = sqlsrv_fetch_object($reporte_agrupado)) {

            fwrite($file,
                    $final->NR_IDENT_PREST_IPS . '|' .
                    $final->NOM_PRESTADOR . '|' .
                    $final->TOTAL_REGISTROS .
                    PHP_EOL);
        }

        //Cierre del archivo 
        fclose($file);

        return $archivo_agrupado;
    }
    /**
     * Metodo que genera un archivo plano con la agrupacion de autorizaciones
     * por prestador y con anticipos
     * @param obj $reporte_agrupado
     * @return string
     */
    function generar_agrupadoAnt($reporte_agrupado) {

        $archivo_agrupado = "log_arc_enviados/agrupado_prestadoresAnticipos.txt";

        //Apertura del archivo plano
        $file = fopen($archivo_agrupado, "w");

        //Encabezado del archivo
        fwrite($file,
                'NR_IDENT_PREST_IPS|' .
                'NOM_PRESTADOR|' .
                'TOTAL_REGISTROS' .
                PHP_EOL);

        while ($final = sqlsrv_fetch_object($reporte_agrupado)) {

            fwrite($file,
                    $final->NR_IDENT_PREST_IPS . '|' .
                    $final->NOM_PRESTADOR . '|' .
                    $final->TOTAL_REGISTROS .
                    PHP_EOL);
        }

        //Cierre del archivo 
        fclose($file);

        return $archivo_agrupado;
    }

    /**
     * Metodo que crea un archivo plano con la trazabilidad de las autorizaciones
     * @param obj $reporte_sabana
     * @return string
     */
    function generar_sabana($reporte_sabana) {

        $archivo_aut = "log_arc_enviados/sabana_aut.txt";

        //Apertura del archivo plano
        $file = fopen($archivo_aut, "w");

        //Encabezado del archivo
        fwrite($file,
                'NO_SOLICITUD|' .
                'NO_AUTORIZACION|' .
                'NUM_CONTRATO|' .
                'F_INI_VIGENCIA|' .
                'F_VENCIMIENTO|' .
                'ESTADO|' .
                'NOM_PRESTADOR|' .
                'NR_IDENT_PREST_IPS|' .
                'TIP_DOCUMENTO_BEN|' .
                'NUM_DOCUMENTO_BEN|' .
                'DES_CAUSAS|' .
                'DES_SERVICIO|' .
                'DES_CLASE' .
                PHP_EOL);

        while ($final = sqlsrv_fetch_object($reporte_sabana)) {

            fwrite($file,
                    $final->NO_SOLICITUD . '|' .
                    $final->NO_AUTORIZACION . '|' .
                    $final->NUM_CONTRATO . '|' .
                    $final->F_INI_VIGENCIA . '|' .
                    $final->F_VENCIMIENTO . '|' .
                    $final->ESTADO . '|' .
                    $final->NOM_PRESTADOR . '|' .
                    $final->NR_IDENT_PREST_IPS . '|' .
                    $final->TP_IDENT_AFILIA . '|' .
                    $final->NR_IDENT_AFILIA . '|' .
                    $final->DES_CAUSAS . '|' .
                    $final->DES_SERVICIO . '|' .
                    $final->DES_CLASE .
                    PHP_EOL);
        }

        //Cierre del archivo 
        fclose($file);

        return $archivo_aut;
    }

}
