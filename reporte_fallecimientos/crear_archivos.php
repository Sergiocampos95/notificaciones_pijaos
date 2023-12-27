<?php

////////////////////////////////////////////////////////////////////////////////
/////////////////////////       SISTEMA GEMA_WEB       /////////////////////////
/////////////////////////      PIJAOS SALUD EPSI      //////////////////////////
//////////////////////       CREACION DE FICHEROS TXT   ////////////////////////
/////////////////////////  DEPARTAMENTO DE DESARROLLO  /////////////////////////
////////////////////////////////////////////////////////////////////////////////
//si no existe la funcion de consulta, la definimos
if (!function_exists('get_fall_urgencia')) {

    /**
     * Metodo que retorna los datos de la consulta de afiliados fallecidos
     * por urgencias via rips
     * @param obj $consulta_urgencias
     * @return array
     */
    function get_fall_urgencia($consulta_urgencias) {

        $data_urgencias = Array();

        while ($respuesta = sqlsrv_fetch_object($consulta_urgencias)) {

            $data_urgencias[] = $respuesta;
        }

        return $data_urgencias;
    }

    /**
     * Metodo que genera un archivo plano con el reporte de fallecidos por 
     * urgencias
     * @param array $data_urgencias
     * @return string
     */
    function generar_arc_urgencias($data_urgencias) {

        $archivo_urgencias = "log_arc_enviados/fall_urg_" . date('d-m-Y') . ".txt";

        //Apertura del archivo plano
        $file = fopen($archivo_urgencias, "w");

        //Encabezado del archivo
        fwrite($file,
                'IDENT_PRESTADOR|' .
                'NUM_IDENT_PRESTADOR|' .
                'COD_HABILITACION|' .
                'NOM_PRESTADOR|' .
                'NUM_REMISION|' .
                'FECHA_REMISION|' .
                'FECHA_CARGUE_REMISION|' .
                'TIP_DOCUMENTO_USUARIO|' .
                'NUM_DOCUMENTO_USUARIO|' .
                'NOM_USUARIO|' .
                'NOM_CIUDAD|' .
                'NOM_DEPARTAMENTO|' .
                'NUM_FACTURA|' .
                'COD_DIAGNOSTICO_MUERTE|' .
                'NOM_GIAGNOSTICO_MUERTE|' .
                'FEC_SALIDA_URGENCIAS|' .
                'HORA_SALIDA_URGENCIAS' .
                PHP_EOL);

        foreach ($data_urgencias as $final) {

            fwrite($file,
                    $final->TIPO_ENTIDAD . '|' .
                    $final->NUM_ENTIDAD . '|' .
                    $final->COD_PRESTADOR . '|' .
                    $final->NOM_PRESTADOR . '|' .
                    $final->NUM_REMISION . '|' .
                    $final->FEC_REMISION . '|' .
                    $final->FEC_CARGUE . '|' .
                    $final->TIPO_DOC_USUARIO . '|' .
                    $final->NUM_DOC_USUARIO . '|' .
                    $final->NOM_USUARIO . '|' .
                    $final->NOM_CIUDAD . '|' .
                    $final->NOM_DEPARTAMENTO . '|' .
                    $final->NUM_FACTURA . '|' .
                    $final->CAUS_MUERTE_URGENCIA . '|' .
                    $final->NOM_DIAGNSOTICO . '|' .
                    $final->FECHA_SALIDA_OBS . '|' .
                    $final->HORA_SALIDA .
                    PHP_EOL);
        }

        //Cierre del archivo 
        fclose($file);

        return $archivo_urgencias;
    }

    /**
     * Metodo que retorna los datos de la consulta de afiliados fallecidos
     * por hospitalizacion via rips 
     * @param obj $consulta_hospitalizaciones
     * @return array
     */
    function get_fall_hospitalizacion($consulta_hospitalizaciones) {

        $data_hospitalizacion = Array();

        while ($respuesta = sqlsrv_fetch_object($consulta_hospitalizaciones)) {

            $data_hospitalizacion[] = $respuesta;
        }

        return $data_hospitalizacion;
    }

    /**
     * Metodo que genera un archivo plano con el reporte de fallecidos por 
     * hospitalizacion
     * @param array $data_hospitalizacion
     * @return string
     */
    function generar_arc_hospitalizacion($data_hospitalizacion) {

        $archivo_hospitalizacion = "log_arc_enviados/fall_hosp_" . date('d-m-Y') . ".txt";

        //Apertura del archivo plano
        $file = fopen($archivo_hospitalizacion, "w");

        //Encabezado del archivo
        fwrite($file,
                'IDENT_PRESTADOR|' .
                'NUM_IDENT_PRESTADOR|' .
                'COD_HABILITACION|' .
                'NOM_PRESTADOR|' .
                'NUM_REMISION|' .
                'FECHA_REMISION|' .
                'FECHA_CARGUE_REMISION|' .
                'TIP_DOCUMENTO_USUARIO|' .
                'NUM_DOCUMENTO_USUARIO|' .
                'NOM_USUARIO|' .
                'NOM_CIUDAD|' .
                'NOM_DEPARTAMENTO|' .
                'NUM_FACTURA|' .
                'COD_DIAGNOSTICO_MUERTE|' .
                'NOM_GIAGNOSTICO_MUERTE|' .
                'FEC_SALIDA_HOSPITALIZACION|' .
                'HORA_SALIDA_HOSPITALIZACION' .
                PHP_EOL);

        foreach ($data_hospitalizacion as $final) {

            fwrite($file,
                    $final->TIPO_ENTIDAD . '|' .
                    $final->NUM_ENTIDAD . '|' .
                    $final->COD_PRESTADOR . '|' .
                    $final->NOM_PRESTADOR . '|' .
                    $final->NUM_REMISION . '|' .
                    $final->FEC_REMISION . '|' .
                    $final->FEC_CARGUE . '|' .
                    $final->TIPO_DOC_USUARIO . '|' .
                    $final->NUM_DOC_USUARIO . '|' .
                    $final->AFILIADO . '|' .
                    $final->NOM_CIUDAD . '|' .
                    $final->NOM_DEPARTAMENTO . '|' .
                    $final->NUM_FACTURA . '|' .
                    $final->COD_DIAG_MUERTE . '|' .
                    $final->NOM_DIAGNSOTICO . '|' .
                    $final->FECHA_EGRE_INST . '|' .
                    $final->HORA_EGRESO .
                    PHP_EOL);
        }

        //Cierre del archivo 
        fclose($file);

        return $archivo_hospitalizacion;
    }

    /**
     * Metodo que retorna los datos de la consulta de afiliados fallecidos
     * por facturacion
     * @param obj $consulta_facturacion
     * @return array
     */
    function get_fall_facturacion($consulta_facturacion) {

        $data_facturacion = Array();

        while ($respuesta = sqlsrv_fetch_object($consulta_facturacion)) {

            $data_facturacion[] = $respuesta;
        }

        return $data_facturacion;
    }

    /**
     * Metodo que genera un archivo plano con el reporte de fallecidos por 
     * facturacion
     * @param array $data_facturacion
     * @return string
     */
    function generar_arc_facturacion($data_facturacion) {

        $archivo_facturacion = "log_arc_enviados/fallecimientos_facturacion_" . date('d-m-Y') . ".txt";

        //Apertura del archivo plano
        $file = fopen($archivo_facturacion, "w");

        //Encabezado del archivo
        fwrite($file,
                'IDENT_PRESTADOR|' .
                'NUM_IDENT_PRESTADOR|' .
                'NOM_PRESTADOR|' .
                'COD_RADICACION|' .
                'FEC_RADICACION|' .
                'NUM_FACTURA|' .
                'NUM_CAJA|' .
                'NUM_PAQUETE|' .
                'TIP_DOCUMENTO_USUARIO|' .
                'NUM_DOCUMENTO_USUARIO|' .
                'NOM_USUARIO|' .
                'NOM_CIUDAD|' .
                'NOM_DEPARTAMENTO|' .
                'FEC_SALIDA' .
                PHP_EOL);

        foreach ($data_facturacion as $final) {

            fwrite($file,
                    $final->TIP_ENTIDAD . '|' .
                    $final->NUM_ENTIDAD . '|' .
                    $final->NOM_ENTIDAD . '|' .
                    $final->COD_RADICACION . '|' .
                    $final->FEC_RADICACION . '|' .
                    $final->NUM_FACTURA . '|' .
                    $final->NUM_CAJA . '|' .
                    $final->NUM_PAQUETE . '|' .
                    $final->TIP_IDENT_USUAR . '|' .
                    $final->NUR_IDENT_USUAR . '|' .
                    $final->NOM_AFILIADO . '|' .
                    $final->NOM_CIUDAD . '|' .
                    $final->NOM_DEPARTAMENTO . '|' .
                    $final->FEC_SALIDA .
                    PHP_EOL);
        }

        //Cierre del archivo 
        fclose($file);

        return $archivo_facturacion;
    }

}
