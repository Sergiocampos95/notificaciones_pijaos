<?php

////////////////////////////////////////////////////////////////////////////////
/////////////////////////       SISTEMA GEMA_WEB       /////////////////////////
/////////////////////////      PIJAOS SALUD EPSI      //////////////////////////
//////////////////////       CREACION DE FICHEROS TXT   ////////////////////////
/////////////////////////  DEPARTAMENTO DE DESARROLLO  /////////////////////////
////////////////////////////////////////////////////////////////////////////////
//si no existe la funcion de consulta, la definimos
if (!function_exists('get_afiliados')) {


    /**
     * Metodo que retorna los datos de la consulta de afiliados con documentos CN, RC y TI desactualizados
     * @param obj $consulta_afiliados
     * @return array
     */
    function get_afiliados($consulta_afiliados) {

        $data_afiliados = Array();

        while ($respuesta = sqlsrv_fetch_object($consulta_afiliados)) {

            $data_afiliados[] = $respuesta;
        }

        return $data_afiliados;
    }

    /**
     * Metodo que genera un archivo plano con el reporte de documentos
     * a actualizar
     * @param obj $data_afiliados
     * @param int $tipo_informe
     * @return String
     */
    function generar_data($data_afiliados, $tipo_informe) {

        switch ($tipo_informe) {
            //Consulta documentos por CN
            case 1:
                $archivo_agrupado = "log_arc_enviados/reporte_CN.txt";
                break;

            //Consulta de documento por RC
            case 2:
                $archivo_agrupado = "log_arc_enviados/reporte_RC.txt";
                break;

            //Consulta documentos por TI
            case 3:
                $archivo_agrupado = "log_arc_enviados/reporte_TI.txt";
                break;
        }

        //Apertura del archivo plano
        $file = fopen($archivo_agrupado, "w");

        //Encabezado del archivo
        fwrite($file,
                'TIPDOC_AFILIADO|' .
                'NUMDOC_AFILIADO|' .
                'PRI_APELLIDO|' .
                'SEG_APELLIDO|' .
                'PRI_NOMBRE|' .
                'SEG_NOMBRE|' .
                'FEC_NACIMIENTO|' .
                'EDAD|' .
                'TIPDOC_COTIZANTE|' .
                'NUMDOC_COTIZANTE|' .
                'DEPARTAMENTO|' .
                'MUNICIPIO|' .
                'DIRECCION|' .
                'TELEFONO_1|' .
                'TELEFONO_2|' .
                'EMAIL|' .
                'FEC_AFILIACION|' .
                'REGIMEN|' .
                'TIPO_POBLACION' .
                PHP_EOL);

        foreach ($data_afiliados as $final) {

            fwrite($file,
                    $final->TIPDOC_AFILIADO . '|' .
                    $final->NUMDOC_AFILIADO . '|' .
                    utf8_decode($final->PRI_APELLIDO) . '|' .
                    utf8_decode($final->SEG_APELLIDO) . '|' .
                    utf8_decode($final->PRI_NOMBRE) . '|' .
                    utf8_decode($final->SEG_NOMBRE) . '|' .
                    $final->FEC_NACIMIENTO . '|' .
                    utf8_decode($final->EDAD) . '|' .
                    $final->TIPDOC_COTIZANTE . '|' .
                    trim($final->NUMDOC_COTIZANTE) . '|' .
                    $final->DEPARTAMENTO . '|' .
                    $final->MUNICIPIO . '|' .
                    $final->DIRECCION . '|' .
                    $final->TELEFONO_1 . '|' .
                    $final->TELEFONO_2 . '|' .
                    $final->EMAIL . '|' .
                    $final->FEC_AFILIACION . '|' .
                    $final->REGIMEN . '|' .
                    $final->TIPO_POBLACION .
                    PHP_EOL);
        }

        //Cierre del archivo 
        fclose($file);

        return $archivo_agrupado;
    }

}
