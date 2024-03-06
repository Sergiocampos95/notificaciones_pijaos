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

        $archivo_agrupado = "log_arc_enviados/agrupado_autorizaciones_oxigeno.txt";

        //eliminacion del archivo TXT si existe
        if (file_exists($archivo_agrupado)) {
            // Intenta eliminar el archivo
            if (unlink($archivo_agrupado)) {
                //Apertura del archivo plano
                $file = fopen($archivo_agrupado, "w");

                //Encabezado del archivo
                fwrite($file,
                        'NO_AUTORIZACION|' .
                        'NO_SOLICITUD|' .
                        'FECHA_AUTORIZACION|' .
                        'FECHA_VENCIMIENTO' .
                        PHP_EOL);

                while ($final = sqlsrv_fetch_object($reporte_agrupado)) {
                // Asigno el valor de las fechas a una variable
                $fechaAutorizacion = $final->FEC_AUTORIZA;
                $fechaVencimiento = $final->FEC_VENCIMIENTO;
                // Formatear la fecha y la hora
                $fechaAutorizacionFormateada = $fechaAutorizacion->format('Y-m-d');
                $fechaAutorizacionVencimiento = $fechaVencimiento->format('Y-m-d');
                    fwrite($file,
                            $final->NO_AUTORIZACION . '|' .
                            $final->NO_SOLICITUD . '|' .
                            $final->NUM_DOCUMENTO_BEN . '|' .
                            $final->PRI_APELLIDO . ' '.$final->SEG_APELLIDO. ' '.$final->PRI_NOMBRE. ' '.$final->NOM_NOMBRE. '|' .
                            $fechaAutorizacionFormateada . '|' .
                            $fechaAutorizacionVencimiento .
                            PHP_EOL);
                }

                //Cierre del archivo 
                fclose($file);

                return $archivo_agrupado;
            } else {
                log_txt("No se pudo eliminar el archivo agrupado_autorizaciones_vencidas.txt");
            }
        } else {
            //Apertura del archivo plano
            $file = fopen($archivo_agrupado, "w");

            //Encabezado del archivo
            fwrite($file,
                    'NO_AUTORIZACION|' .
                    'NO_SOLICITUD|' .
                    'FECHA_AUTORIZACION|' .
                    'FECHA_VENCIMIENTO' .
                    PHP_EOL);

            while ($final = sqlsrv_fetch_object($reporte_agrupado)) {
                // Asigno el valor de las fechas a una variable
                $fechaAutorizacion = $final->FEC_AUTORIZA;
                $fechaVencimiento = $final->FEC_VENCIMIENTO;
                // Formatear la fecha y la hora
                $fechaAutorizacionFormateada = $fechaAutorizacion->format('Y-m-d');
                $fechaAutorizacionVencimiento = $fechaVencimiento->format('Y-m-d');
                fwrite($file,
                        $final->NO_AUTORIZACION . '|' .
                        $final->NO_SOLICITUD . '|' .
                        $final->NUM_DOCUMENTO_BEN . '|' .
                        $final->PRI_APELLIDO . ' '.$final->SEG_APELLIDO. ' '.$final->PRI_NOMBRE. ' '.$final->NOM_NOMBRE. '|' .
                        $fechaAutorizacionFormateada . '|' .
                        $fechaAutorizacionVencimiento .
                        PHP_EOL);
            }

            //Cierre del archivo 
            fclose($file);

            return $archivo_agrupado;
        }
    }
}
