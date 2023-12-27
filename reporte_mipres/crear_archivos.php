<?php

////////////////////////////////////////////////////////////////////////////////
/////////////////////////       SISTEMA GEMA_WEB       /////////////////////////
/////////////////////////      PIJAOS SALUD EPSI      //////////////////////////
//////////////////////       CREACION DE FICHEROS TXT   ////////////////////////
/////////////////////////  DEPARTAMENTO DE DESARROLLO  /////////////////////////
////////////////////////////////////////////////////////////////////////////////
//si no existe la funcion de consulta, la definimos
if (!function_exists('generar_arc_direccionamientos')) {

    /**
     * Metodo que genera un archivo plano con la sabana de trazabilidad solo con los direccionamientos
     * @param array $reporte_traza
     * @return string
     */
    function generar_arc_direccionamientos20($reporte_traza) {


        $archivo_direccionamientos = "log_arc_enviados/TrazabilidadC_2020.txt";

        //Apertura del archivo plano
        $file = fopen($archivo_direccionamientos, "w");

        //Encabezado del archivo
        fwrite($file,
                'NOPRESCRIPCION|' .
                'FPRESCRIPCION|' .
                'TIPOIDIPS|' .
                'NROIDIPS|' .
                'NOMIDIPS|' .
                'NOMDANEMUNIPS|' .
                'TIPOIDPROF|' .
                'NUMIDPROF|' .
                'NOMROFS|' .
                'TIPOIDPACIENTE|' .
                'NROIDPACIENTE|' .
                'NOMPACIENTE|' .
                'DESAMBATE|' .
                'CODDXPPAL|' .
                'REPORTMIPRES|' .
                'EST_PRES_TUT|' .
                'REGIMEN|' .
                'TIPOTEC|' .
                'CONTEC|' .
                'COD_MIPRES|' .
                'DESC_SERVICIO|' .
                'ESTJM|' .
                'FECHAACTA|' .
                'FPROCESO|' .
                'ID_TRAZABILIDAD|' .
                'IDDIR_IDNODIR|' .
                'DIR_NODIR|' .
                'CODEPS|' .
                'NOENTREGA|' .
                'NOSUBENTREGA|' .
                'CAUSANOENTREGA|' .
                'TIPOIDPROV|' .
                'NOIDPROV|' .
                'NOMPROV|' .
                'NOMMUNENT|' .
                'FECMAXENT|' .
                'CODSERTECAENTREGAR|' .
                'CANTTOTAENTREGAR|' .
                'FECDIR_FECNODIR|' .
                'IDREPORTEENTREGA|' .
                'ESTADOENTREGA|' .
                'CAUSANOENTREGAREP|' .
                'CODTECENTREGADO|' .
                'CANTTOTENTREGADAREP|' .
                'VALORENTREGADOREP|' .
                'FECENTREGA|' .
                'FECREPENTREGA|' .
                'IDSUMINISTRO|' .
                'VERSION|' .
                'ULTENTREGA|' .
                'ENTREGACOMPLETA|' .
                'CAUSANOENTREGASUM|' .
                'CANTTOTENTREGADASUM|' .
                'VALORENTREGADOSUM|' .
                'FECREPSUMINISTRO|' .
                'FECSUMINISTRO_VERSION1|' .
                'CODTECNENTREGADO_VERSION1|' .
                'TIPOIDENTIDAD_VERSION1|' .
                'NOIDPRESTSUMSERV_VERSION1|' .
                'NO_SOLICITUD|' .
                'ESTADO_AUT|' .
                'FEC_AUTORIZACION|' .
                'FEC_VENCIMIENTO|' .
                'TARIFARIO|' .
                'CD_SERVICIO|' .
                'DESCRIPCION|' .
                'VALOR_AUT_SERVICIO|' .
                'CANTIDAD|' .
                'VALOR_TOTAL_AUT_SERVICIO|' .
                'COD_RADICACION|' .
                'PREFIJO|' .
                'NUM_FACTURA|' .
                'FEC_RADICACION|' .
                'FEC_ATENCION|' .
                'ID_TRAZABILIDAD_FACTURACION|' .
                'IDFACTURACION|' .
                'NOENTREGAFAC|' .
                'NOSUBENTREGAFAC|' .
                'NOFACTURA|' .
                'CODEPSFAC|' .
                'CODSERTECAENTREGADO|' .
                'CANTUNMINDIS|' .
                'VALORUNITFACTURADO|' .
                'VALORTOTFACTURADO|' .
                'CUOTAMODER|' .
                'COPAGO|' .
                'FECFACTURACION|' .
                'IDDATOSFACTURADO|' .
                'COMPADM|' .
                'CODCOMPADMHOM|' .
                'UNICOMPADMHOM|' .
                'VALUNMICON|' .
                'CANTTOTENT|' .
                'VALTOTCOMPADMHOM|' .
                'FECDATOSFACTURADO|' .
                'FEC_CORTE_REPORTE|' .
                'CALIDAD' .
                PHP_EOL);


        while ($final = sqlsrv_fetch_object($reporte_traza)) {


            $FPRESCRIPCION = (is_null($final->FPRESCRIPCION) ? "" : $final->FPRESCRIPCION->format('Y-m-d'));
            $FECHAACTA = (is_null($final->FECHAACTA)) ? "" : $final->FECHAACTA->format('Y-m-d');
            $FPROCESO = (is_null($final->FPROCESO)) ? "" : $final->FPROCESO->format('Y-m-d');
            $FECMAXENT = (is_null($final->FECMAXENT)) ? "" : $final->FECMAXENT->format('Y-m-d');
            $FECDIR_FECNODIR = (is_null($final->FECDIR_FECNODIR)) ? "" : $final->FECDIR_FECNODIR->format('Y-m-d');
            $FECENTREGA = (is_null($final->FECENTREGA)) ? "" : $final->FECENTREGA->format('Y-m-d');
            $FECREPENTREGA = (is_null($final->FECREPENTREGA)) ? "" : $final->FECREPENTREGA->format('Y-m-d');
            $FECREPSUMINISTRO = (is_null($final->FECREPSUMINISTRO)) ? "" : $final->FECREPSUMINISTRO->format('Y-m-d');
            $FECSUMINISTRO_VERSION1 = (is_null($final->FECSUMINISTRO_VERSION1)) ? "" : $final->FECSUMINISTRO_VERSION1->format('Y-m-d');
            $FEC_AUTORIZACION = (is_null($final->FEC_AUTORIZACION)) ? "" : $final->FEC_AUTORIZACION->format('Y-m-d');
            $FEC_VENCIMIENTO = (is_null($final->FEC_VENCIMIENTO)) ? "" : $final->FEC_VENCIMIENTO->format('Y-m-d');
            $FEC_RADICACION = (is_null($final->FEC_RADICACION)) ? "" : $final->FEC_RADICACION->format('Y-m-d');
            $FEC_ATENCION = (is_null($final->FEC_ATENCION)) ? "" : $final->FEC_ATENCION->format('Y-m-d');
            $FECFACTURACION = (is_null($final->FECFACTURACION)) ? "" : $final->FECFACTURACION->format('Y-m-d');
            $FECDATOSFACTURADO = (is_null($final->FECDATOSFACTURADO)) ? "" : $final->FECDATOSFACTURADO;
            $FEC_CORTE_REPORTE = (is_null($final->FEC_CORTE_REPORTE)) ? "" : $final->FEC_CORTE_REPORTE->format('Y-m-d');


            fwrite($file,
                    $final->NOPRESCRIPCION . '|' .
                    $FPRESCRIPCION . '|' .
                    $final->TIPOIDIPS . '|' .
                    $final->NROIDIPS . '|' .
                    $final->NOMIDIPS . '|' .
                    $final->NOMDANEMUNIPS . '|' .
                    $final->TIPOIDPROF . '|' .
                    $final->NUMIDPROF . '|' .
                    utf8_decode($final->NOMROFS) . '|' .
                    $final->TIPOIDPACIENTE . '|' .
                    $final->NROIDPACIENTE . '|' .
                    utf8_decode($final->NOMPACIENTE) . '|' .
                    utf8_decode($final->DESAMBATE) . '|' .
                    $final->CODDXPPAL . '|' .
                    $final->REPORTMIPRES . '|' .
                    $final->EST_PRES_TUT . '|' .
                    $final->REGIMEN . '|' .
                    $final->TIPOTEC . '|' .
                    $final->CONTEC . '|' .
                    $final->COD_MIPRES . '|' .
                    utf8_decode($final->DESC_SERVICIO) . '|' .
                    $final->ESTJM . '|' .
                    $FECHAACTA . '|' .
                    $FPROCESO . '|' .
                    $final->ID_TRAZABILIDAD . '|' .
                    $final->IDDIR_IDNODIR . '|' .
                    $final->DIR_NODIR . '|' .
                    $final->CODEPS . '|' .
                    $final->NOENTREGA . '|' .
                    $final->NOSUBENTREGA . '|' .
                    $final->CAUSANOENTREGA . '|' .
                    $final->TIPOIDPROV . '|' .
                    $final->NOIDPROV . '|' .
                    $final->NOMPROV . '|' .
                    $final->NOMMUNENT . '|' .
                    $FECMAXENT . '|' .
                    $final->CODSERTECAENTREGAR . '|' .
                    $final->CANTTOTAENTREGAR . '|' .
                    $FECDIR_FECNODIR . '|' .
                    $final->IDREPORTEENTREGA . '|' .
                    $final->ESTADOENTREGA . '|' .
                    $final->CAUSANOENTREGAREP . '|' .
                    $final->CODTECENTREGADO . '|' .
                    $final->CANTTOTENTREGADAREP . '|' .
                    $final->VALORENTREGADOREP . '|' .
                    $FECENTREGA . '|' .
                    $FECREPENTREGA . '|' .
                    $final->IDSUMINISTRO . '|' .
                    $final->VERSION . '|' .
                    $final->ULTENTREGA . '|' .
                    $final->ENTREGACOMPLETA . '|' .
                    $final->CAUSANOENTREGASUM . '|' .
                    $final->CANTTOTENTREGADASUM . '|' .
                    $final->VALORENTREGADOSUM . '|' .
                    $FECREPSUMINISTRO . '|' .
                    $FECSUMINISTRO_VERSION1 . '|' .
                    $final->CODTECNENTREGADO_VERSION1 . '|' .
                    $final->TIPOIDENTIDAD_VERSION1 . '|' .
                    $final->NOIDPRESTSUMSERV_VERSION1 . '|' .
                    $final->NO_SOLICITUD . '|' .
                    $final->ESTADO_AUT . '|' .
                    $FEC_AUTORIZACION . '|' .
                    $FEC_VENCIMIENTO . '|' .
                    $final->TARIFARIO . '|' .
                    $final->CD_SERVICIO . '|' .
                    utf8_decode($final->DESCRIPCION) . '|' .
                    $final->VALOR_AUT_SERVICIO . '|' .
                    $final->CANTIDAD . '|' .
                    $final->VALOR_TOTAL_AUT_SERVICIO . '|' .
                    $final->COD_RADICACION . '|' .
                    $final->PREFIJO . '|' .
                    $final->NUM_FACTURA . '|' .
                    $FEC_RADICACION . '|' .
                    $FEC_ATENCION . '|' .
                    $final->ID_TRAZABILIDAD_FACTURACION . '|' .
                    $final->IDFACTURACION . '|' .
                    $final->NOENTREGAFAC . '|' .
                    $final->NOSUBENTREGAFAC . '|' .
                    trim($final->NOFACTURA) . '|' .
                    $final->CODEPSFAC . '|' .
                    $final->CODSERTECAENTREGADO . '|' .
                    $final->CANTUNMINDIS . '|' .
                    $final->VALORUNITFACTURADO . '|' .
                    $final->VALORTOTFACTURADO . '|' .
                    $final->CUOTAMODER . '|' .
                    $final->COPAGO . '|' .
                    $FECFACTURACION . '|' .
                    $final->IDDATOSFACTURADO . '|' .
                    $final->COMPADM . '|' .
                    $final->CODCOMPADMHOM . '|' .
                    $final->UNICOMPADMHOM . '|' .
                    $final->VALUNMICON . '|' .
                    $final->CANTTOTENT . '|' .
                    $final->VALTOTCOMPADMHOM . '|' .
                    $FECDATOSFACTURADO . '|' .
                    $FEC_CORTE_REPORTE . '|' .
                    $final->CALIDAD .
                    PHP_EOL);
        }


        return $archivo_direccionamientos;
    }

    /**
     * Metodo que genera un archivo plano con la 
     * sabana de trazabilidad solo con los direccionamientos de urgencias y hospitalizaciones
     * @param array $reporte_trazaUH
     * @return string
     */
    function generar_arc_direUH20($reporte_trazaUH) {

        $archivo_direccionamientosUH = "log_arc_enviados/TrazabilidadUH_2020.txt";

        //Apertura del archivo plano
        $file = fopen($archivo_direccionamientosUH, "w");

        //Encabezado del archivo
        fwrite($file,
                'NOPRESCRIPCION|' .
                'FPRESCRIPCION|' .
                'TIPOIDIPS|' .
                'NROIDIPS|' .
                'NOMIDIPS|' .
                'NOMDANEMUNIPS|' .
                'TIPOIDPROF|' .
                'NUMIDPROF|' .
                'NOMROFS|' .
                'TIPOIDPACIENTE|' .
                'NROIDPACIENTE|' .
                'NOMPACIENTE|' .
                'DESAMBATE|' .
                'CODDXPPAL|' .
                'REPORTMIPRES|' .
                'EST_PRES_TUT|' .
                'REGIMEN|' .
                'TIPOTEC|' .
                'CONTEC|' .
                'COD_MIPRES|' .
                'DESC_SERVICIO|' .
                'ESTJM|' .
                'FECHAACTA|' .
                'FPROCESO|' .
                'ID_TRAZABILIDAD|' .
                'IDDIR_IDNODIR|' .
                'DIR_NODIR|' .
                'CODEPS|' .
                'NOENTREGA|' .
                'NOSUBENTREGA|' .
                'CAUSANOENTREGA|' .
                'TIPOIDPROV|' .
                'NOIDPROV|' .
                'NOMPROV|' .
                'NOMMUNENT|' .
                'FECMAXENT|' .
                'CODSERTECAENTREGAR|' .
                'CANTTOTAENTREGAR|' .
                'FECDIR_FECNODIR|' .
                'IDREPORTEENTREGA|' .
                'ESTADOENTREGA|' .
                'CAUSANOENTREGAREP|' .
                'CODTECENTREGADO|' .
                'CANTTOTENTREGADAREP|' .
                'VALORENTREGADOREP|' .
                'FECENTREGA|' .
                'FECREPENTREGA|' .
                'IDSUMINISTRO|' .
                'VERSION|' .
                'ULTENTREGA|' .
                'ENTREGACOMPLETA|' .
                'CAUSANOENTREGASUM|' .
                'CANTTOTENTREGADASUM|' .
                'VALORENTREGADOSUM|' .
                'FECREPSUMINISTRO|' .
                'FECSUMINISTRO_VERSION1|' .
                'CODTECNENTREGADO_VERSION1|' .
                'TIPOIDENTIDAD_VERSION1|' .
                'NOIDPRESTSUMSERV_VERSION1|' .
                'NO_SOLICITUD|' .
                'ESTADO_AUT|' .
                'FEC_AUTORIZACION|' .
                'FEC_VENCIMIENTO|' .
                'TARIFARIO|' .
                'CD_SERVICIO|' .
                'DESCRIPCION|' .
                'VALOR_AUT_SERVICIO|' .
                'CANTIDAD|' .
                'VALOR_TOTAL_AUT_SERVICIO|' .
                'COD_RADICACION|' .
                'PREFIJO|' .
                'NUM_FACTURA|' .
                'FEC_RADICACION|' .
                'FEC_ATENCION|' .
                'ID_TRAZABILIDAD_FACTURACION|' .
                'IDFACTURACION|' .
                'NOENTREGAFAC|' .
                'NOSUBENTREGAFAC|' .
                'NOFACTURA|' .
                'CODEPSFAC|' .
                'CODSERTECAENTREGADO|' .
                'CANTUNMINDIS|' .
                'VALORUNITFACTURADO|' .
                'VALORTOTFACTURADO|' .
                'CUOTAMODER|' .
                'COPAGO|' .
                'FECFACTURACION|' .
                'IDDATOSFACTURADO|' .
                'COMPADM|' .
                'CODCOMPADMHOM|' .
                'UNICOMPADMHOM|' .
                'VALUNMICON|' .
                'CANTTOTENT|' .
                'VALTOTCOMPADMHOM|' .
                'FECDATOSFACTURADO|' .
                'FEC_CORTE_REPORTE|' .
                'CALIDAD' .
                PHP_EOL);


        while ($final = sqlsrv_fetch_object($reporte_trazaUH)) {

            $FPRESCRIPCION = (is_null($final->FPRESCRIPCION) ? "" : $final->FPRESCRIPCION->format('Y-m-d'));
            $FECHAACTA = (is_null($final->FECHAACTA)) ? "" : $final->FECHAACTA->format('Y-m-d');
            $FPROCESO = (is_null($final->FPROCESO)) ? "" : $final->FPROCESO->format('Y-m-d');
            $FECMAXENT = (is_null($final->FECMAXENT)) ? "" : $final->FECMAXENT->format('Y-m-d');
            $FECDIR_FECNODIR = (is_null($final->FECDIR_FECNODIR)) ? "" : $final->FECDIR_FECNODIR->format('Y-m-d');
            $FECENTREGA = (is_null($final->FECENTREGA)) ? "" : $final->FECENTREGA->format('Y-m-d');
            $FECREPENTREGA = (is_null($final->FECREPENTREGA)) ? "" : $final->FECREPENTREGA->format('Y-m-d');
            $FECREPSUMINISTRO = (is_null($final->FECREPSUMINISTRO)) ? "" : $final->FECREPSUMINISTRO->format('Y-m-d');
            //$FECSUMINISTRO_VERSION1 = (is_null($final->FECSUMINISTRO_VERSION1)) ? "" : $final->FECSUMINISTRO_VERSION1->format('Y-m-d');
            $FECSUMINISTRO_VERSION1 = $final->FECSUMINISTRO_VERSION1;
            $FEC_AUTORIZACION = (is_null($final->FEC_AUTORIZACION)) ? "" : $final->FEC_AUTORIZACION->format('Y-m-d');
            $FEC_VENCIMIENTO = (is_null($final->FEC_VENCIMIENTO)) ? "" : $final->FEC_VENCIMIENTO->format('Y-m-d');
            $FEC_RADICACION = (is_null($final->FEC_RADICACION)) ? "" : $final->FEC_RADICACION->format('Y-m-d');
            $FEC_ATENCION = (is_null($final->FEC_ATENCION)) ? "" : $final->FEC_ATENCION->format('Y-m-d');
            $FECFACTURACION = (is_null($final->FECFACTURACION)) ? "" : $final->FECFACTURACION->format('Y-m-d');
            $FECDATOSFACTURADO = (is_null($final->FECDATOSFACTURADO)) ? "" : $final->FECDATOSFACTURADO;
            $FEC_CORTE_REPORTE = (is_null($final->FEC_CORTE_REPORTE)) ? "" : $final->FEC_CORTE_REPORTE->format('Y-m-d');


            fwrite($file,
                    trim($final->NOPRESCRIPCION) . '|' .
                    $FPRESCRIPCION . '|' .
                    trim($final->TIPOIDIPS) . '|' .
                    trim($final->NROIDIPS) . '|' .
                    trim($final->NOMIDIPS) . '|' .
                    trim($final->NOMDANEMUNIPS) . '|' .
                    trim($final->TIPOIDPROF) . '|' .
                    trim($final->NUMIDPROF) . '|' .
                    trim(utf8_decode($final->NOMROFS)) . '|' .
                    trim($final->TIPOIDPACIENTE) . '|' .
                    trim($final->NROIDPACIENTE) . '|' .
                    trim(utf8_decode($final->NOMPACIENTE)) . '|' .
                    trim(utf8_decode($final->DESAMBATE)) . '|' .
                    trim($final->CODDXPPAL) . '|' .
                    trim($final->REPORTMIPRES) . '|' .
                    trim($final->EST_PRES_TUT) . '|' .
                    trim($final->REGIMEN) . '|' .
                    trim($final->TIPOTEC) . '|' .
                    trim($final->CONTEC) . '|' .
                    trim($final->COD_MIPRES) . '|' .
                    trim(utf8_decode($final->DESC_SERVICIO)) . '|' .
                    trim($final->ESTJM) . '|' .
                    $FECHAACTA . '|' .
                    $FPROCESO . '|' .
                    trim($final->ID_TRAZABILIDAD) . '|' .
                    trim($final->IDDIR_IDNODIR) . '|' .
                    trim($final->DIR_NODIR) . '|' .
                    trim($final->CODEPS) . '|' .
                    trim($final->NOENTREGA) . '|' .
                    trim($final->NOSUBENTREGA) . '|' .
                    trim($final->CAUSANOENTREGA) . '|' .
                    trim($final->TIPOIDPROV) . '|' .
                    trim($final->NOIDPROV) . '|' .
                    trim($final->NOMPROV) . '|' .
                    trim($final->NOMMUNENT) . '|' .
                    $FECMAXENT . '|' .
                    trim($final->CODSERTECAENTREGAR) . '|' .
                    trim($final->CANTTOTAENTREGAR) . '|' .
                    $FECDIR_FECNODIR . '|' .
                    trim($final->IDREPORTEENTREGA) . '|' .
                    trim($final->ESTADOENTREGA) . '|' .
                    trim($final->CAUSANOENTREGAREP) . '|' .
                    trim($final->CODTECENTREGADO) . '|' .
                    trim($final->CANTTOTENTREGADAREP) . '|' .
                    trim($final->VALORENTREGADOREP) . '|' .
                    $FECENTREGA . '|' .
                    $FECREPENTREGA . '|' .
                    trim($final->IDSUMINISTRO) . '|' .
                    trim($final->VERSION) . '|' .
                    trim($final->ULTENTREGA) . '|' .
                    trim($final->ENTREGACOMPLETA) . '|' .
                    trim($final->CAUSANOENTREGASUM) . '|' .
                    trim($final->CANTTOTENTREGADASUM) . '|' .
                    trim($final->VALORENTREGADOSUM) . '|' .
                    $FECREPSUMINISTRO . '|' .
                    $FECSUMINISTRO_VERSION1 . '|' .
                    trim($final->CODTECNENTREGADO_VERSION1) . '|' .
                    trim($final->TIPOIDENTIDAD_VERSION1) . '|' .
                    trim($final->NOIDPRESTSUMSERV_VERSION1) . '|' .
                    trim($final->NO_SOLICITUD) . '|' .
                    trim($final->ESTADO_AUT) . '|' .
                    $FEC_AUTORIZACION . '|' .
                    $FEC_VENCIMIENTO . '|' .
                    trim($final->TARIFARIO) . '|' .
                    trim($final->CD_SERVICIO) . '|' .
                    trim(utf8_decode($final->DESCRIPCION)) . '|' .
                    trim($final->VALOR_AUT_SERVICIO) . '|' .
                    trim($final->CANTIDAD) . '|' .
                    trim($final->VALOR_TOTAL_AUT_SERVICIO) . '|' .
                    trim($final->COD_RADICACION) . '|' .
                    trim($final->PREFIJO) . '|' .
                    trim($final->NUM_FACTURA) . '|' .
                    $FEC_RADICACION . '|' .
                    $FEC_ATENCION . '|' .
                    trim($final->ID_TRAZABILIDAD_FACTURACION) . '|' .
                    trim($final->IDFACTURACION) . '|' .
                    trim($final->NOENTREGAFAC) . '|' .
                    trim($final->NOSUBENTREGAFAC) . '|' .
                    trim($final->NOFACTURA) . '|' .
                    trim($final->CODEPSFAC) . '|' .
                    trim($final->CODSERTECAENTREGADO) . '|' .
                    trim($final->CANTUNMINDIS) . '|' .
                    trim($final->VALORUNITFACTURADO) . '|' .
                    trim($final->VALORTOTFACTURADO) . '|' .
                    trim($final->CUOTAMODER) . '|' .
                    trim($final->COPAGO) . '|' .
                    $FECFACTURACION . '|' .
                    trim($final->IDDATOSFACTURADO) . '|' .
                    trim($final->COMPADM) . '|' .
                    trim($final->CODCOMPADMHOM) . '|' .
                    trim($final->UNICOMPADMHOM) . '|' .
                    trim($final->VALUNMICON) . '|' .
                    trim($final->CANTTOTENT) . '|' .
                    trim($final->VALTOTCOMPADMHOM) . '|' .
                    $FECDATOSFACTURADO . '|' .
                    $FEC_CORTE_REPORTE . '|' .
                    trim($final->CALIDAD) .
                    PHP_EOL);
        }


        return $archivo_direccionamientosUH;
    }

    /**
     * Metodo que genera un archivo plano con la sabana de trazabilidad solo con los direccionamientos del año 2021
     * @param array $reporte_traza
     * @return string
     */
    function generar_arc_direccionamientos21($reporte_traza) {

        $archivo_direccionamientos = "log_arc_enviados/TrazabilidadC_2021.txt";

        //Apertura del archivo plano
        $file = fopen($archivo_direccionamientos, "w");

        //Encabezado del archivo
        fwrite($file,
                'NOPRESCRIPCION|' .
                'FPRESCRIPCION|' .
                'TIPOIDIPS|' .
                'NROIDIPS|' .
                'NOMIDIPS|' .
                'NOMDANEMUNIPS|' .
                'TIPOIDPROF|' .
                'NUMIDPROF|' .
                'NOMROFS|' .
                'TIPOIDPACIENTE|' .
                'NROIDPACIENTE|' .
                'NOMPACIENTE|' .
                'DESAMBATE|' .
                'CODDXPPAL|' .
                'REPORTMIPRES|' .
                'EST_PRES_TUT|' .
                'REGIMEN|' .
                'TIPOTEC|' .
                'CONTEC|' .
                'COD_MIPRES|' .
                'DESC_SERVICIO|' .
                'ESTJM|' .
                'FECHAACTA|' .
                'FPROCESO|' .
                'ID_TRAZABILIDAD|' .
                'IDDIR_IDNODIR|' .
                'DIR_NODIR|' .
                'CODEPS|' .
                'NOENTREGA|' .
                'NOSUBENTREGA|' .
                'CAUSANOENTREGA|' .
                'TIPOIDPROV|' .
                'NOIDPROV|' .
                'NOMPROV|' .
                'NOMMUNENT|' .
                'FECMAXENT|' .
                'CODSERTECAENTREGAR|' .
                'CANTTOTAENTREGAR|' .
                'FECDIR_FECNODIR|' .
                'IDREPORTEENTREGA|' .
                'ESTADOENTREGA|' .
                'CAUSANOENTREGAREP|' .
                'CODTECENTREGADO|' .
                'CANTTOTENTREGADAREP|' .
                'VALORENTREGADOREP|' .
                'FECENTREGA|' .
                'FECREPENTREGA|' .
                'IDSUMINISTRO|' .
                'VERSION|' .
                'ULTENTREGA|' .
                'ENTREGACOMPLETA|' .
                'CAUSANOENTREGASUM|' .
                'CANTTOTENTREGADASUM|' .
                'VALORENTREGADOSUM|' .
                'FECREPSUMINISTRO|' .
                'FECSUMINISTRO_VERSION1|' .
                'CODTECNENTREGADO_VERSION1|' .
                'TIPOIDENTIDAD_VERSION1|' .
                'NOIDPRESTSUMSERV_VERSION1|' .
                'NO_SOLICITUD|' .
                'ESTADO_AUT|' .
                'FEC_AUTORIZACION|' .
                'FEC_VENCIMIENTO|' .
                'TARIFARIO|' .
                'CD_SERVICIO|' .
                'DESCRIPCION|' .
                'VALOR_AUT_SERVICIO|' .
                'CANTIDAD|' .
                'VALOR_TOTAL_AUT_SERVICIO|' .
                'COD_RADICACION|' .
                'PREFIJO|' .
                'NUM_FACTURA|' .
                'FEC_RADICACION|' .
                'FEC_ATENCION|' .
                'ID_TRAZABILIDAD_FACTURACION|' .
                'IDFACTURACION|' .
                'NOENTREGAFAC|' .
                'NOSUBENTREGAFAC|' .
                'NOFACTURA|' .
                'CODEPSFAC|' .
                'CODSERTECAENTREGADO|' .
                'CANTUNMINDIS|' .
                'VALORUNITFACTURADO|' .
                'VALORTOTFACTURADO|' .
                'CUOTAMODER|' .
                'COPAGO|' .
                'FECFACTURACION|' .
                'IDDATOSFACTURADO|' .
                'COMPADM|' .
                'CODCOMPADMHOM|' .
                'UNICOMPADMHOM|' .
                'VALUNMICON|' .
                'CANTTOTENT|' .
                'VALTOTCOMPADMHOM|' .
                'FECDATOSFACTURADO|' .
                'FEC_CORTE_REPORTE|' .
                'CALIDAD' .
                PHP_EOL);


        while ($final = sqlsrv_fetch_object($reporte_traza)) {


            $FPRESCRIPCION = (is_null($final->FPRESCRIPCION) ? "" : $final->FPRESCRIPCION->format('Y-m-d'));
            $FECHAACTA = (is_null($final->FECHAACTA)) ? "" : $final->FECHAACTA->format('Y-m-d');
            $FPROCESO = (is_null($final->FPROCESO)) ? "" : $final->FPROCESO->format('Y-m-d');
            $FECMAXENT = (is_null($final->FECMAXENT)) ? "" : $final->FECMAXENT->format('Y-m-d');
            $FECDIR_FECNODIR = (is_null($final->FECDIR_FECNODIR)) ? "" : $final->FECDIR_FECNODIR->format('Y-m-d');
            $FECENTREGA = (is_null($final->FECENTREGA)) ? "" : $final->FECENTREGA->format('Y-m-d');
            $FECREPENTREGA = (is_null($final->FECREPENTREGA)) ? "" : $final->FECREPENTREGA->format('Y-m-d');
            $FECREPSUMINISTRO = (is_null($final->FECREPSUMINISTRO)) ? "" : $final->FECREPSUMINISTRO->format('Y-m-d');
            $FECSUMINISTRO_VERSION1 = (is_null($final->FECSUMINISTRO_VERSION1)) ? "" : $final->FECSUMINISTRO_VERSION1->format('Y-m-d');
            $FEC_AUTORIZACION = (is_null($final->FEC_AUTORIZACION)) ? "" : $final->FEC_AUTORIZACION->format('Y-m-d');
            $FEC_VENCIMIENTO = (is_null($final->FEC_VENCIMIENTO)) ? "" : $final->FEC_VENCIMIENTO->format('Y-m-d');
            $FEC_RADICACION = (is_null($final->FEC_RADICACION)) ? "" : $final->FEC_RADICACION->format('Y-m-d');
            $FEC_ATENCION = (is_null($final->FEC_ATENCION)) ? "" : $final->FEC_ATENCION->format('Y-m-d');
            $FECFACTURACION = (is_null($final->FECFACTURACION)) ? "" : $final->FECFACTURACION->format('Y-m-d');
            $FECDATOSFACTURADO = (is_null($final->FECDATOSFACTURADO)) ? "" : $final->FECDATOSFACTURADO;
            $FEC_CORTE_REPORTE = (is_null($final->FEC_CORTE_REPORTE)) ? "" : $final->FEC_CORTE_REPORTE->format('Y-m-d');


            fwrite($file,
                    $final->NOPRESCRIPCION . '|' .
                    $FPRESCRIPCION . '|' .
                    $final->TIPOIDIPS . '|' .
                    $final->NROIDIPS . '|' .
                    $final->NOMIDIPS . '|' .
                    $final->NOMDANEMUNIPS . '|' .
                    $final->TIPOIDPROF . '|' .
                    $final->NUMIDPROF . '|' .
                    utf8_decode($final->NOMROFS) . '|' .
                    $final->TIPOIDPACIENTE . '|' .
                    $final->NROIDPACIENTE . '|' .
                    utf8_decode($final->NOMPACIENTE) . '|' .
                    utf8_decode($final->DESAMBATE) . '|' .
                    $final->CODDXPPAL . '|' .
                    $final->REPORTMIPRES . '|' .
                    $final->EST_PRES_TUT . '|' .
                    $final->REGIMEN . '|' .
                    $final->TIPOTEC . '|' .
                    $final->CONTEC . '|' .
                    $final->COD_MIPRES . '|' .
                    utf8_decode($final->DESC_SERVICIO) . '|' .
                    $final->ESTJM . '|' .
                    $FECHAACTA . '|' .
                    $FPROCESO . '|' .
                    $final->ID_TRAZABILIDAD . '|' .
                    $final->IDDIR_IDNODIR . '|' .
                    $final->DIR_NODIR . '|' .
                    $final->CODEPS . '|' .
                    $final->NOENTREGA . '|' .
                    $final->NOSUBENTREGA . '|' .
                    $final->CAUSANOENTREGA . '|' .
                    $final->TIPOIDPROV . '|' .
                    $final->NOIDPROV . '|' .
                    $final->NOMPROV . '|' .
                    $final->NOMMUNENT . '|' .
                    $FECMAXENT . '|' .
                    $final->CODSERTECAENTREGAR . '|' .
                    $final->CANTTOTAENTREGAR . '|' .
                    $FECDIR_FECNODIR . '|' .
                    $final->IDREPORTEENTREGA . '|' .
                    $final->ESTADOENTREGA . '|' .
                    $final->CAUSANOENTREGAREP . '|' .
                    $final->CODTECENTREGADO . '|' .
                    $final->CANTTOTENTREGADAREP . '|' .
                    $final->VALORENTREGADOREP . '|' .
                    $FECENTREGA . '|' .
                    $FECREPENTREGA . '|' .
                    $final->IDSUMINISTRO . '|' .
                    $final->VERSION . '|' .
                    $final->ULTENTREGA . '|' .
                    $final->ENTREGACOMPLETA . '|' .
                    $final->CAUSANOENTREGASUM . '|' .
                    $final->CANTTOTENTREGADASUM . '|' .
                    $final->VALORENTREGADOSUM . '|' .
                    $FECREPSUMINISTRO . '|' .
                    $FECSUMINISTRO_VERSION1 . '|' .
                    $final->CODTECNENTREGADO_VERSION1 . '|' .
                    $final->TIPOIDENTIDAD_VERSION1 . '|' .
                    $final->NOIDPRESTSUMSERV_VERSION1 . '|' .
                    $final->NO_SOLICITUD . '|' .
                    $final->ESTADO_AUT . '|' .
                    $FEC_AUTORIZACION . '|' .
                    $FEC_VENCIMIENTO . '|' .
                    $final->TARIFARIO . '|' .
                    $final->CD_SERVICIO . '|' .
                    utf8_decode($final->DESCRIPCION) . '|' .
                    $final->VALOR_AUT_SERVICIO . '|' .
                    $final->CANTIDAD . '|' .
                    $final->VALOR_TOTAL_AUT_SERVICIO . '|' .
                    $final->COD_RADICACION . '|' .
                    $final->PREFIJO . '|' .
                    $final->NUM_FACTURA . '|' .
                    $FEC_RADICACION . '|' .
                    $FEC_ATENCION . '|' .
                    $final->ID_TRAZABILIDAD_FACTURACION . '|' .
                    $final->IDFACTURACION . '|' .
                    $final->NOENTREGAFAC . '|' .
                    $final->NOSUBENTREGAFAC . '|' .
                    trim($final->NOFACTURA) . '|' .
                    $final->CODEPSFAC . '|' .
                    $final->CODSERTECAENTREGADO . '|' .
                    $final->CANTUNMINDIS . '|' .
                    $final->VALORUNITFACTURADO . '|' .
                    $final->VALORTOTFACTURADO . '|' .
                    $final->CUOTAMODER . '|' .
                    $final->COPAGO . '|' .
                    $FECFACTURACION . '|' .
                    $final->IDDATOSFACTURADO . '|' .
                    $final->COMPADM . '|' .
                    $final->CODCOMPADMHOM . '|' .
                    $final->UNICOMPADMHOM . '|' .
                    $final->VALUNMICON . '|' .
                    $final->CANTTOTENT . '|' .
                    $final->VALTOTCOMPADMHOM . '|' .
                    $FECDATOSFACTURADO . '|' .
                    $FEC_CORTE_REPORTE . '|' .
                    $final->CALIDAD .
                    PHP_EOL);
        }

        return $archivo_direccionamientos;
    }

    /**
     * Metodo que genera un archivo plano con la 
     * sabana de trazabilidad solo con los direccionamientos de urgencias y hospitalizaciones del año 2021
     * @param array $reporte_trazaUH
     * @return string
     */
    function generar_arc_direUH21($reporte_trazaUH) {


        $archivo_direccionamientosUH = "log_arc_enviados/TrazabilidadUH_2021.txt";

        //Apertura del archivo plano
        $file = fopen($archivo_direccionamientosUH, "w");

        //Encabezado del archivo
        fwrite($file,
                'NOPRESCRIPCION|' .
                'FPRESCRIPCION|' .
                'TIPOIDIPS|' .
                'NROIDIPS|' .
                'NOMIDIPS|' .
                'NOMDANEMUNIPS|' .
                'TIPOIDPROF|' .
                'NUMIDPROF|' .
                'NOMROFS|' .
                'TIPOIDPACIENTE|' .
                'NROIDPACIENTE|' .
                'NOMPACIENTE|' .
                'DESAMBATE|' .
                'CODDXPPAL|' .
                'REPORTMIPRES|' .
                'EST_PRES_TUT|' .
                'REGIMEN|' .
                'TIPOTEC|' .
                'CONTEC|' .
                'COD_MIPRES|' .
                'DESC_SERVICIO|' .
                'ESTJM|' .
                'FECHAACTA|' .
                'FPROCESO|' .
                'ID_TRAZABILIDAD|' .
                'IDDIR_IDNODIR|' .
                'DIR_NODIR|' .
                'CODEPS|' .
                'NOENTREGA|' .
                'NOSUBENTREGA|' .
                'CAUSANOENTREGA|' .
                'TIPOIDPROV|' .
                'NOIDPROV|' .
                'NOMPROV|' .
                'NOMMUNENT|' .
                'FECMAXENT|' .
                'CODSERTECAENTREGAR|' .
                'CANTTOTAENTREGAR|' .
                'FECDIR_FECNODIR|' .
                'IDREPORTEENTREGA|' .
                'ESTADOENTREGA|' .
                'CAUSANOENTREGAREP|' .
                'CODTECENTREGADO|' .
                'CANTTOTENTREGADAREP|' .
                'VALORENTREGADOREP|' .
                'FECENTREGA|' .
                'FECREPENTREGA|' .
                'IDSUMINISTRO|' .
                'VERSION|' .
                'ULTENTREGA|' .
                'ENTREGACOMPLETA|' .
                'CAUSANOENTREGASUM|' .
                'CANTTOTENTREGADASUM|' .
                'VALORENTREGADOSUM|' .
                'FECREPSUMINISTRO|' .
                'FECSUMINISTRO_VERSION1|' .
                'CODTECNENTREGADO_VERSION1|' .
                'TIPOIDENTIDAD_VERSION1|' .
                'NOIDPRESTSUMSERV_VERSION1|' .
                'NO_SOLICITUD|' .
                'ESTADO_AUT|' .
                'FEC_AUTORIZACION|' .
                'FEC_VENCIMIENTO|' .
                'TARIFARIO|' .
                'CD_SERVICIO|' .
                'DESCRIPCION|' .
                'VALOR_AUT_SERVICIO|' .
                'CANTIDAD|' .
                'VALOR_TOTAL_AUT_SERVICIO|' .
                'COD_RADICACION|' .
                'PREFIJO|' .
                'NUM_FACTURA|' .
                'FEC_RADICACION|' .
                'FEC_ATENCION|' .
                'ID_TRAZABILIDAD_FACTURACION|' .
                'IDFACTURACION|' .
                'NOENTREGAFAC|' .
                'NOSUBENTREGAFAC|' .
                'NOFACTURA|' .
                'CODEPSFAC|' .
                'CODSERTECAENTREGADO|' .
                'CANTUNMINDIS|' .
                'VALORUNITFACTURADO|' .
                'VALORTOTFACTURADO|' .
                'CUOTAMODER|' .
                'COPAGO|' .
                'FECFACTURACION|' .
                'IDDATOSFACTURADO|' .
                'COMPADM|' .
                'CODCOMPADMHOM|' .
                'UNICOMPADMHOM|' .
                'VALUNMICON|' .
                'CANTTOTENT|' .
                'VALTOTCOMPADMHOM|' .
                'FECDATOSFACTURADO|' .
                'FEC_CORTE_REPORTE|' .
                'CALIDAD' .
                PHP_EOL);


        while ($final = sqlsrv_fetch_object($reporte_trazaUH)) {


            $FPRESCRIPCION = (is_null($final->FPRESCRIPCION) ? "" : $final->FPRESCRIPCION->format('Y-m-d'));
            $FECHAACTA = (is_null($final->FECHAACTA)) ? "" : $final->FECHAACTA->format('Y-m-d');
            $FPROCESO = (is_null($final->FPROCESO)) ? "" : $final->FPROCESO->format('Y-m-d');
            $FECMAXENT = (is_null($final->FECMAXENT)) ? "" : $final->FECMAXENT->format('Y-m-d');
            $FECDIR_FECNODIR = (is_null($final->FECDIR_FECNODIR)) ? "" : $final->FECDIR_FECNODIR->format('Y-m-d');
            $FECENTREGA = (is_null($final->FECENTREGA)) ? "" : $final->FECENTREGA->format('Y-m-d');
            $FECREPENTREGA = (is_null($final->FECREPENTREGA)) ? "" : $final->FECREPENTREGA->format('Y-m-d');
            $FECREPSUMINISTRO = (is_null($final->FECREPSUMINISTRO)) ? "" : $final->FECREPSUMINISTRO->format('Y-m-d');
            //$FECSUMINISTRO_VERSION1 = (is_null($final->FECSUMINISTRO_VERSION1)) ? "" : $final->FECSUMINISTRO_VERSION1->format('Y-m-d');
            $FECSUMINISTRO_VERSION1 = $final->FECSUMINISTRO_VERSION1;
            $FEC_AUTORIZACION = (is_null($final->FEC_AUTORIZACION)) ? "" : $final->FEC_AUTORIZACION->format('Y-m-d');
            $FEC_VENCIMIENTO = (is_null($final->FEC_VENCIMIENTO)) ? "" : $final->FEC_VENCIMIENTO->format('Y-m-d');
            $FEC_RADICACION = (is_null($final->FEC_RADICACION)) ? "" : $final->FEC_RADICACION->format('Y-m-d');
            $FEC_ATENCION = (is_null($final->FEC_ATENCION)) ? "" : $final->FEC_ATENCION->format('Y-m-d');
            $FECFACTURACION = (is_null($final->FECFACTURACION)) ? "" : $final->FECFACTURACION->format('Y-m-d');
            $FECDATOSFACTURADO = (is_null($final->FECDATOSFACTURADO)) ? "" : $final->FECDATOSFACTURADO;
            $FEC_CORTE_REPORTE = (is_null($final->FEC_CORTE_REPORTE)) ? "" : $final->FEC_CORTE_REPORTE->format('Y-m-d');


            fwrite($file,
                    $final->NOPRESCRIPCION . '|' .
                    $FPRESCRIPCION . '|' .
                    $final->TIPOIDIPS . '|' .
                    $final->NROIDIPS . '|' .
                    $final->NOMIDIPS . '|' .
                    $final->NOMDANEMUNIPS . '|' .
                    $final->TIPOIDPROF . '|' .
                    $final->NUMIDPROF . '|' .
                    utf8_decode($final->NOMROFS) . '|' .
                    $final->TIPOIDPACIENTE . '|' .
                    $final->NROIDPACIENTE . '|' .
                    utf8_decode($final->NOMPACIENTE) . '|' .
                    utf8_decode($final->DESAMBATE) . '|' .
                    $final->CODDXPPAL . '|' .
                    $final->REPORTMIPRES . '|' .
                    $final->EST_PRES_TUT . '|' .
                    $final->REGIMEN . '|' .
                    $final->TIPOTEC . '|' .
                    $final->CONTEC . '|' .
                    $final->COD_MIPRES . '|' .
                    utf8_decode($final->DESC_SERVICIO) . '|' .
                    $final->ESTJM . '|' .
                    $FECHAACTA . '|' .
                    $FPROCESO . '|' .
                    $final->ID_TRAZABILIDAD . '|' .
                    $final->IDDIR_IDNODIR . '|' .
                    $final->DIR_NODIR . '|' .
                    $final->CODEPS . '|' .
                    $final->NOENTREGA . '|' .
                    $final->NOSUBENTREGA . '|' .
                    $final->CAUSANOENTREGA . '|' .
                    $final->TIPOIDPROV . '|' .
                    $final->NOIDPROV . '|' .
                    $final->NOMPROV . '|' .
                    $final->NOMMUNENT . '|' .
                    $FECMAXENT . '|' .
                    $final->CODSERTECAENTREGAR . '|' .
                    $final->CANTTOTAENTREGAR . '|' .
                    $FECDIR_FECNODIR . '|' .
                    $final->IDREPORTEENTREGA . '|' .
                    $final->ESTADOENTREGA . '|' .
                    $final->CAUSANOENTREGAREP . '|' .
                    $final->CODTECENTREGADO . '|' .
                    $final->CANTTOTENTREGADAREP . '|' .
                    $final->VALORENTREGADOREP . '|' .
                    $FECENTREGA . '|' .
                    $FECREPENTREGA . '|' .
                    $final->IDSUMINISTRO . '|' .
                    $final->VERSION . '|' .
                    $final->ULTENTREGA . '|' .
                    $final->ENTREGACOMPLETA . '|' .
                    $final->CAUSANOENTREGASUM . '|' .
                    $final->CANTTOTENTREGADASUM . '|' .
                    $final->VALORENTREGADOSUM . '|' .
                    $FECREPSUMINISTRO . '|' .
                    $FECSUMINISTRO_VERSION1 . '|' .
                    $final->CODTECNENTREGADO_VERSION1 . '|' .
                    $final->TIPOIDENTIDAD_VERSION1 . '|' .
                    $final->NOIDPRESTSUMSERV_VERSION1 . '|' .
                    $final->NO_SOLICITUD . '|' .
                    $final->ESTADO_AUT . '|' .
                    $FEC_AUTORIZACION . '|' .
                    $FEC_VENCIMIENTO . '|' .
                    $final->TARIFARIO . '|' .
                    $final->CD_SERVICIO . '|' .
                    utf8_decode($final->DESCRIPCION) . '|' .
                    $final->VALOR_AUT_SERVICIO . '|' .
                    $final->CANTIDAD . '|' .
                    $final->VALOR_TOTAL_AUT_SERVICIO . '|' .
                    $final->COD_RADICACION . '|' .
                    $final->PREFIJO . '|' .
                    $final->NUM_FACTURA . '|' .
                    $FEC_RADICACION . '|' .
                    $FEC_ATENCION . '|' .
                    $final->ID_TRAZABILIDAD_FACTURACION . '|' .
                    $final->IDFACTURACION . '|' .
                    $final->NOENTREGAFAC . '|' .
                    $final->NOSUBENTREGAFAC . '|' .
                    trim($final->NOFACTURA) . '|' .
                    $final->CODEPSFAC . '|' .
                    $final->CODSERTECAENTREGADO . '|' .
                    $final->CANTUNMINDIS . '|' .
                    $final->VALORUNITFACTURADO . '|' .
                    $final->VALORTOTFACTURADO . '|' .
                    $final->CUOTAMODER . '|' .
                    $final->COPAGO . '|' .
                    $FECFACTURACION . '|' .
                    $final->IDDATOSFACTURADO . '|' .
                    $final->COMPADM . '|' .
                    $final->CODCOMPADMHOM . '|' .
                    $final->UNICOMPADMHOM . '|' .
                    $final->VALUNMICON . '|' .
                    $final->CANTTOTENT . '|' .
                    $final->VALTOTCOMPADMHOM . '|' .
                    $FECDATOSFACTURADO . '|' .
                    $FEC_CORTE_REPORTE . '|' .
                    $final->CALIDAD .
                    PHP_EOL);
        }

        return $archivo_direccionamientosUH;
    }

    /**
     * Metodo que genera un archivo plano con la sabana de trazabilidad solo con los direccionamientos del año 2022
     * @param array $reporte_traza
     * @return string
     */
    function generar_arc_direccionamientos22($reporte_traza) {

        $archivo_direccionamientos = "log_arc_enviados/TrazabilidadC_2022.txt";

        //Apertura del archivo plano
        $file = fopen($archivo_direccionamientos, "w");

        //Encabezado del archivo
        fwrite($file,
                'NOPRESCRIPCION|' .
                'FPRESCRIPCION|' .
                'TIPOIDIPS|' .
                'NROIDIPS|' .
                'NOMIDIPS|' .
                'NOMDANEMUNIPS|' .
                'TIPOIDPROF|' .
                'NUMIDPROF|' .
                'NOMROFS|' .
                'TIPOIDPACIENTE|' .
                'NROIDPACIENTE|' .
                'NOMPACIENTE|' .
                'DESAMBATE|' .
                'CODDXPPAL|' .
                'REPORTMIPRES|' .
                'EST_PRES_TUT|' .
                'REGIMEN|' .
                'TIPOTEC|' .
                'CONTEC|' .
                'COD_MIPRES|' .
                'DESC_SERVICIO|' .
                'ESTJM|' .
                'FECHAACTA|' .
                'FPROCESO|' .
                'ID_TRAZABILIDAD|' .
                'IDDIR_IDNODIR|' .
                'DIR_NODIR|' .
                'CODEPS|' .
                'NOENTREGA|' .
                'NOSUBENTREGA|' .
                'CAUSANOENTREGA|' .
                'TIPOIDPROV|' .
                'NOIDPROV|' .
                'NOMPROV|' .
                'NOMMUNENT|' .
                'FECMAXENT|' .
                'CODSERTECAENTREGAR|' .
                'CANTTOTAENTREGAR|' .
                'FECDIR_FECNODIR|' .
                'IDREPORTEENTREGA|' .
                'ESTADOENTREGA|' .
                'CAUSANOENTREGAREP|' .
                'CODTECENTREGADO|' .
                'CANTTOTENTREGADAREP|' .
                'VALORENTREGADOREP|' .
                'FECENTREGA|' .
                'FECREPENTREGA|' .
                'IDSUMINISTRO|' .
                'VERSION|' .
                'ULTENTREGA|' .
                'ENTREGACOMPLETA|' .
                'CAUSANOENTREGASUM|' .
                'CANTTOTENTREGADASUM|' .
                'VALORENTREGADOSUM|' .
                'FECREPSUMINISTRO|' .
                'FECSUMINISTRO_VERSION1|' .
                'CODTECNENTREGADO_VERSION1|' .
                'TIPOIDENTIDAD_VERSION1|' .
                'NOIDPRESTSUMSERV_VERSION1|' .
                'NO_SOLICITUD|' .
                'ESTADO_AUT|' .
                'FEC_AUTORIZACION|' .
                'FEC_VENCIMIENTO|' .
                'TARIFARIO|' .
                'CD_SERVICIO|' .
                'DESCRIPCION|' .
                'VALOR_AUT_SERVICIO|' .
                'CANTIDAD|' .
                'VALOR_TOTAL_AUT_SERVICIO|' .
                'COD_RADICACION|' .
                'PREFIJO|' .
                'NUM_FACTURA|' .
                'FEC_RADICACION|' .
                'FEC_ATENCION|' .
                'ID_TRAZABILIDAD_FACTURACION|' .
                'IDFACTURACION|' .
                'NOENTREGAFAC|' .
                'NOSUBENTREGAFAC|' .
                'NOFACTURA|' .
                'CODEPSFAC|' .
                'CODSERTECAENTREGADO|' .
                'CANTUNMINDIS|' .
                'VALORUNITFACTURADO|' .
                'VALORTOTFACTURADO|' .
                'CUOTAMODER|' .
                'COPAGO|' .
                'FECFACTURACION|' .
                'IDDATOSFACTURADO|' .
                'COMPADM|' .
                'CODCOMPADMHOM|' .
                'UNICOMPADMHOM|' .
                'VALUNMICON|' .
                'CANTTOTENT|' .
                'VALTOTCOMPADMHOM|' .
                'FECDATOSFACTURADO|' .
                'FEC_CORTE_REPORTE|' .
                'CALIDAD' .
                PHP_EOL);


        while ($final = sqlsrv_fetch_object($reporte_traza)) {


            $FPRESCRIPCION = (is_null($final->FPRESCRIPCION) ? "" : $final->FPRESCRIPCION->format('Y-m-d'));
            $FECHAACTA = (is_null($final->FECHAACTA)) ? "" : $final->FECHAACTA->format('Y-m-d');
            $FPROCESO = (is_null($final->FPROCESO)) ? "" : $final->FPROCESO->format('Y-m-d');
            $FECMAXENT = (is_null($final->FECMAXENT)) ? "" : $final->FECMAXENT->format('Y-m-d');
            $FECDIR_FECNODIR = (is_null($final->FECDIR_FECNODIR)) ? "" : $final->FECDIR_FECNODIR->format('Y-m-d');
            $FECENTREGA = (is_null($final->FECENTREGA)) ? "" : $final->FECENTREGA->format('Y-m-d');
            $FECREPENTREGA = (is_null($final->FECREPENTREGA)) ? "" : $final->FECREPENTREGA->format('Y-m-d');
            $FECREPSUMINISTRO = (is_null($final->FECREPSUMINISTRO)) ? "" : $final->FECREPSUMINISTRO->format('Y-m-d');
            $FECSUMINISTRO_VERSION1 = (is_null($final->FECSUMINISTRO_VERSION1)) ? "" : $final->FECSUMINISTRO_VERSION1->format('Y-m-d');
            $FEC_AUTORIZACION = (is_null($final->FEC_AUTORIZACION)) ? "" : $final->FEC_AUTORIZACION->format('Y-m-d');
            $FEC_VENCIMIENTO = (is_null($final->FEC_VENCIMIENTO)) ? "" : $final->FEC_VENCIMIENTO->format('Y-m-d');
            $FEC_RADICACION = (is_null($final->FEC_RADICACION)) ? "" : $final->FEC_RADICACION->format('Y-m-d');
            $FEC_ATENCION = (is_null($final->FEC_ATENCION)) ? "" : $final->FEC_ATENCION->format('Y-m-d');
            $FECFACTURACION = (is_null($final->FECFACTURACION)) ? "" : $final->FECFACTURACION->format('Y-m-d');
            $FECDATOSFACTURADO = (is_null($final->FECDATOSFACTURADO)) ? "" : $final->FECDATOSFACTURADO;
            $FEC_CORTE_REPORTE = (is_null($final->FEC_CORTE_REPORTE)) ? "" : $final->FEC_CORTE_REPORTE->format('Y-m-d');


            fwrite($file,
                    $final->NOPRESCRIPCION . '|' .
                    $FPRESCRIPCION . '|' .
                    $final->TIPOIDIPS . '|' .
                    $final->NROIDIPS . '|' .
                    $final->NOMIDIPS . '|' .
                    $final->NOMDANEMUNIPS . '|' .
                    $final->TIPOIDPROF . '|' .
                    $final->NUMIDPROF . '|' .
                    utf8_decode($final->NOMROFS) . '|' .
                    $final->TIPOIDPACIENTE . '|' .
                    $final->NROIDPACIENTE . '|' .
                    utf8_decode($final->NOMPACIENTE) . '|' .
                    utf8_decode($final->DESAMBATE) . '|' .
                    $final->CODDXPPAL . '|' .
                    $final->REPORTMIPRES . '|' .
                    $final->EST_PRES_TUT . '|' .
                    $final->REGIMEN . '|' .
                    $final->TIPOTEC . '|' .
                    $final->CONTEC . '|' .
                    $final->COD_MIPRES . '|' .
                    utf8_decode($final->DESC_SERVICIO) . '|' .
                    $final->ESTJM . '|' .
                    $FECHAACTA . '|' .
                    $FPROCESO . '|' .
                    $final->ID_TRAZABILIDAD . '|' .
                    $final->IDDIR_IDNODIR . '|' .
                    $final->DIR_NODIR . '|' .
                    $final->CODEPS . '|' .
                    $final->NOENTREGA . '|' .
                    $final->NOSUBENTREGA . '|' .
                    $final->CAUSANOENTREGA . '|' .
                    $final->TIPOIDPROV . '|' .
                    $final->NOIDPROV . '|' .
                    $final->NOMPROV . '|' .
                    $final->NOMMUNENT . '|' .
                    $FECMAXENT . '|' .
                    $final->CODSERTECAENTREGAR . '|' .
                    $final->CANTTOTAENTREGAR . '|' .
                    $FECDIR_FECNODIR . '|' .
                    $final->IDREPORTEENTREGA . '|' .
                    $final->ESTADOENTREGA . '|' .
                    $final->CAUSANOENTREGAREP . '|' .
                    $final->CODTECENTREGADO . '|' .
                    $final->CANTTOTENTREGADAREP . '|' .
                    $final->VALORENTREGADOREP . '|' .
                    $FECENTREGA . '|' .
                    $FECREPENTREGA . '|' .
                    $final->IDSUMINISTRO . '|' .
                    $final->VERSION . '|' .
                    $final->ULTENTREGA . '|' .
                    $final->ENTREGACOMPLETA . '|' .
                    $final->CAUSANOENTREGASUM . '|' .
                    $final->CANTTOTENTREGADASUM . '|' .
                    $final->VALORENTREGADOSUM . '|' .
                    $FECREPSUMINISTRO . '|' .
                    $FECSUMINISTRO_VERSION1 . '|' .
                    $final->CODTECNENTREGADO_VERSION1 . '|' .
                    $final->TIPOIDENTIDAD_VERSION1 . '|' .
                    $final->NOIDPRESTSUMSERV_VERSION1 . '|' .
                    $final->NO_SOLICITUD . '|' .
                    $final->ESTADO_AUT . '|' .
                    $FEC_AUTORIZACION . '|' .
                    $FEC_VENCIMIENTO . '|' .
                    $final->TARIFARIO . '|' .
                    $final->CD_SERVICIO . '|' .
                    utf8_decode($final->DESCRIPCION) . '|' .
                    $final->VALOR_AUT_SERVICIO . '|' .
                    $final->CANTIDAD . '|' .
                    $final->VALOR_TOTAL_AUT_SERVICIO . '|' .
                    $final->COD_RADICACION . '|' .
                    $final->PREFIJO . '|' .
                    $final->NUM_FACTURA . '|' .
                    $FEC_RADICACION . '|' .
                    $FEC_ATENCION . '|' .
                    $final->ID_TRAZABILIDAD_FACTURACION . '|' .
                    $final->IDFACTURACION . '|' .
                    $final->NOENTREGAFAC . '|' .
                    $final->NOSUBENTREGAFAC . '|' .
                    trim($final->NOFACTURA) . '|' .
                    $final->CODEPSFAC . '|' .
                    $final->CODSERTECAENTREGADO . '|' .
                    $final->CANTUNMINDIS . '|' .
                    $final->VALORUNITFACTURADO . '|' .
                    $final->VALORTOTFACTURADO . '|' .
                    $final->CUOTAMODER . '|' .
                    $final->COPAGO . '|' .
                    $FECFACTURACION . '|' .
                    $final->IDDATOSFACTURADO . '|' .
                    $final->COMPADM . '|' .
                    $final->CODCOMPADMHOM . '|' .
                    $final->UNICOMPADMHOM . '|' .
                    $final->VALUNMICON . '|' .
                    $final->CANTTOTENT . '|' .
                    $final->VALTOTCOMPADMHOM . '|' .
                    $FECDATOSFACTURADO . '|' .
                    $FEC_CORTE_REPORTE . '|' .
                    $final->CALIDAD .
                    PHP_EOL);
        }

        return $archivo_direccionamientos;
    }

    /**
     * Metodo que genera un archivo plano con la 
     * sabana de trazabilidad solo con los direccionamientos de urgencias y hospitalizaciones del año 2022
     * @param array $reporte_trazaUH
     * @return string
     */
    function generar_arc_direUH22($reporte_trazaUH) {


        $archivo_direccionamientosUH = "log_arc_enviados/TrazabilidadUH_2022.txt";

        //Apertura del archivo plano
        $file = fopen($archivo_direccionamientosUH, "w");

        //Encabezado del archivo
        fwrite($file,
                'NOPRESCRIPCION|' .
                'FPRESCRIPCION|' .
                'TIPOIDIPS|' .
                'NROIDIPS|' .
                'NOMIDIPS|' .
                'NOMDANEMUNIPS|' .
                'TIPOIDPROF|' .
                'NUMIDPROF|' .
                'NOMROFS|' .
                'TIPOIDPACIENTE|' .
                'NROIDPACIENTE|' .
                'NOMPACIENTE|' .
                'DESAMBATE|' .
                'CODDXPPAL|' .
                'REPORTMIPRES|' .
                'EST_PRES_TUT|' .
                'REGIMEN|' .
                'TIPOTEC|' .
                'CONTEC|' .
                'COD_MIPRES|' .
                'DESC_SERVICIO|' .
                'ESTJM|' .
                'FECHAACTA|' .
                'FPROCESO|' .
                'ID_TRAZABILIDAD|' .
                'IDDIR_IDNODIR|' .
                'DIR_NODIR|' .
                'CODEPS|' .
                'NOENTREGA|' .
                'NOSUBENTREGA|' .
                'CAUSANOENTREGA|' .
                'TIPOIDPROV|' .
                'NOIDPROV|' .
                'NOMPROV|' .
                'NOMMUNENT|' .
                'FECMAXENT|' .
                'CODSERTECAENTREGAR|' .
                'CANTTOTAENTREGAR|' .
                'FECDIR_FECNODIR|' .
                'IDREPORTEENTREGA|' .
                'ESTADOENTREGA|' .
                'CAUSANOENTREGAREP|' .
                'CODTECENTREGADO|' .
                'CANTTOTENTREGADAREP|' .
                'VALORENTREGADOREP|' .
                'FECENTREGA|' .
                'FECREPENTREGA|' .
                'IDSUMINISTRO|' .
                'VERSION|' .
                'ULTENTREGA|' .
                'ENTREGACOMPLETA|' .
                'CAUSANOENTREGASUM|' .
                'CANTTOTENTREGADASUM|' .
                'VALORENTREGADOSUM|' .
                'FECREPSUMINISTRO|' .
                'FECSUMINISTRO_VERSION1|' .
                'CODTECNENTREGADO_VERSION1|' .
                'TIPOIDENTIDAD_VERSION1|' .
                'NOIDPRESTSUMSERV_VERSION1|' .
                'NO_SOLICITUD|' .
                'ESTADO_AUT|' .
                'FEC_AUTORIZACION|' .
                'FEC_VENCIMIENTO|' .
                'TARIFARIO|' .
                'CD_SERVICIO|' .
                'DESCRIPCION|' .
                'VALOR_AUT_SERVICIO|' .
                'CANTIDAD|' .
                'VALOR_TOTAL_AUT_SERVICIO|' .
                'COD_RADICACION|' .
                'PREFIJO|' .
                'NUM_FACTURA|' .
                'FEC_RADICACION|' .
                'FEC_ATENCION|' .
                'ID_TRAZABILIDAD_FACTURACION|' .
                'IDFACTURACION|' .
                'NOENTREGAFAC|' .
                'NOSUBENTREGAFAC|' .
                'NOFACTURA|' .
                'CODEPSFAC|' .
                'CODSERTECAENTREGADO|' .
                'CANTUNMINDIS|' .
                'VALORUNITFACTURADO|' .
                'VALORTOTFACTURADO|' .
                'CUOTAMODER|' .
                'COPAGO|' .
                'FECFACTURACION|' .
                'IDDATOSFACTURADO|' .
                'COMPADM|' .
                'CODCOMPADMHOM|' .
                'UNICOMPADMHOM|' .
                'VALUNMICON|' .
                'CANTTOTENT|' .
                'VALTOTCOMPADMHOM|' .
                'FECDATOSFACTURADO|' .
                'FEC_CORTE_REPORTE|' .
                'CALIDAD' .
                PHP_EOL);


        while ($final = sqlsrv_fetch_object($reporte_trazaUH)) {


            $FPRESCRIPCION = (is_null($final->FPRESCRIPCION) ? "" : $final->FPRESCRIPCION->format('Y-m-d'));
            $FECHAACTA = (is_null($final->FECHAACTA)) ? "" : $final->FECHAACTA->format('Y-m-d');
            $FPROCESO = (is_null($final->FPROCESO)) ? "" : $final->FPROCESO->format('Y-m-d');
            $FECMAXENT = (is_null($final->FECMAXENT)) ? "" : $final->FECMAXENT->format('Y-m-d');
            $FECDIR_FECNODIR = (is_null($final->FECDIR_FECNODIR)) ? "" : $final->FECDIR_FECNODIR->format('Y-m-d');
            $FECENTREGA = (is_null($final->FECENTREGA)) ? "" : $final->FECENTREGA->format('Y-m-d');
            $FECREPENTREGA = (is_null($final->FECREPENTREGA)) ? "" : $final->FECREPENTREGA->format('Y-m-d');
            $FECREPSUMINISTRO = (is_null($final->FECREPSUMINISTRO)) ? "" : $final->FECREPSUMINISTRO->format('Y-m-d');
            //$FECSUMINISTRO_VERSION1 = (is_null($final->FECSUMINISTRO_VERSION1)) ? "" : $final->FECSUMINISTRO_VERSION1->format('Y-m-d');
            $FECSUMINISTRO_VERSION1 = $final->FECSUMINISTRO_VERSION1;
            $FEC_AUTORIZACION = (is_null($final->FEC_AUTORIZACION)) ? "" : $final->FEC_AUTORIZACION->format('Y-m-d');
            $FEC_VENCIMIENTO = (is_null($final->FEC_VENCIMIENTO)) ? "" : $final->FEC_VENCIMIENTO->format('Y-m-d');
            $FEC_RADICACION = (is_null($final->FEC_RADICACION)) ? "" : $final->FEC_RADICACION->format('Y-m-d');
            $FEC_ATENCION = (is_null($final->FEC_ATENCION)) ? "" : $final->FEC_ATENCION->format('Y-m-d');
            $FECFACTURACION = (is_null($final->FECFACTURACION)) ? "" : $final->FECFACTURACION->format('Y-m-d');
            $FECDATOSFACTURADO = (is_null($final->FECDATOSFACTURADO)) ? "" : $final->FECDATOSFACTURADO;
            $FEC_CORTE_REPORTE = (is_null($final->FEC_CORTE_REPORTE)) ? "" : $final->FEC_CORTE_REPORTE->format('Y-m-d');


            fwrite($file,
                    $final->NOPRESCRIPCION . '|' .
                    $FPRESCRIPCION . '|' .
                    $final->TIPOIDIPS . '|' .
                    $final->NROIDIPS . '|' .
                    $final->NOMIDIPS . '|' .
                    $final->NOMDANEMUNIPS . '|' .
                    $final->TIPOIDPROF . '|' .
                    $final->NUMIDPROF . '|' .
                    utf8_decode($final->NOMROFS) . '|' .
                    $final->TIPOIDPACIENTE . '|' .
                    $final->NROIDPACIENTE . '|' .
                    utf8_decode($final->NOMPACIENTE) . '|' .
                    utf8_decode($final->DESAMBATE) . '|' .
                    $final->CODDXPPAL . '|' .
                    $final->REPORTMIPRES . '|' .
                    $final->EST_PRES_TUT . '|' .
                    $final->REGIMEN . '|' .
                    $final->TIPOTEC . '|' .
                    $final->CONTEC . '|' .
                    $final->COD_MIPRES . '|' .
                    utf8_decode($final->DESC_SERVICIO) . '|' .
                    $final->ESTJM . '|' .
                    $FECHAACTA . '|' .
                    $FPROCESO . '|' .
                    $final->ID_TRAZABILIDAD . '|' .
                    $final->IDDIR_IDNODIR . '|' .
                    $final->DIR_NODIR . '|' .
                    $final->CODEPS . '|' .
                    $final->NOENTREGA . '|' .
                    $final->NOSUBENTREGA . '|' .
                    $final->CAUSANOENTREGA . '|' .
                    $final->TIPOIDPROV . '|' .
                    $final->NOIDPROV . '|' .
                    $final->NOMPROV . '|' .
                    $final->NOMMUNENT . '|' .
                    $FECMAXENT . '|' .
                    $final->CODSERTECAENTREGAR . '|' .
                    $final->CANTTOTAENTREGAR . '|' .
                    $FECDIR_FECNODIR . '|' .
                    $final->IDREPORTEENTREGA . '|' .
                    $final->ESTADOENTREGA . '|' .
                    $final->CAUSANOENTREGAREP . '|' .
                    $final->CODTECENTREGADO . '|' .
                    $final->CANTTOTENTREGADAREP . '|' .
                    $final->VALORENTREGADOREP . '|' .
                    $FECENTREGA . '|' .
                    $FECREPENTREGA . '|' .
                    $final->IDSUMINISTRO . '|' .
                    $final->VERSION . '|' .
                    $final->ULTENTREGA . '|' .
                    $final->ENTREGACOMPLETA . '|' .
                    $final->CAUSANOENTREGASUM . '|' .
                    $final->CANTTOTENTREGADASUM . '|' .
                    $final->VALORENTREGADOSUM . '|' .
                    $FECREPSUMINISTRO . '|' .
                    $FECSUMINISTRO_VERSION1 . '|' .
                    $final->CODTECNENTREGADO_VERSION1 . '|' .
                    $final->TIPOIDENTIDAD_VERSION1 . '|' .
                    $final->NOIDPRESTSUMSERV_VERSION1 . '|' .
                    $final->NO_SOLICITUD . '|' .
                    $final->ESTADO_AUT . '|' .
                    $FEC_AUTORIZACION . '|' .
                    $FEC_VENCIMIENTO . '|' .
                    $final->TARIFARIO . '|' .
                    $final->CD_SERVICIO . '|' .
                    utf8_decode($final->DESCRIPCION) . '|' .
                    $final->VALOR_AUT_SERVICIO . '|' .
                    $final->CANTIDAD . '|' .
                    $final->VALOR_TOTAL_AUT_SERVICIO . '|' .
                    $final->COD_RADICACION . '|' .
                    $final->PREFIJO . '|' .
                    $final->NUM_FACTURA . '|' .
                    $FEC_RADICACION . '|' .
                    $FEC_ATENCION . '|' .
                    $final->ID_TRAZABILIDAD_FACTURACION . '|' .
                    $final->IDFACTURACION . '|' .
                    $final->NOENTREGAFAC . '|' .
                    $final->NOSUBENTREGAFAC . '|' .
                    trim($final->NOFACTURA) . '|' .
                    $final->CODEPSFAC . '|' .
                    $final->CODSERTECAENTREGADO . '|' .
                    $final->CANTUNMINDIS . '|' .
                    $final->VALORUNITFACTURADO . '|' .
                    $final->VALORTOTFACTURADO . '|' .
                    $final->CUOTAMODER . '|' .
                    $final->COPAGO . '|' .
                    $FECFACTURACION . '|' .
                    $final->IDDATOSFACTURADO . '|' .
                    $final->COMPADM . '|' .
                    $final->CODCOMPADMHOM . '|' .
                    $final->UNICOMPADMHOM . '|' .
                    $final->VALUNMICON . '|' .
                    $final->CANTTOTENT . '|' .
                    $final->VALTOTCOMPADMHOM . '|' .
                    $FECDATOSFACTURADO . '|' .
                    $FEC_CORTE_REPORTE . '|' .
                    $final->CALIDAD .
                    PHP_EOL);
        }

        return $archivo_direccionamientosUH;
    }


}
