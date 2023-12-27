<?php

////////////////////////////////////////////////////////////////////////////////
/////////////////////////       SISTEMA GRAFICAS       /////////////////////////
/////////////////////////      PIJAOS SALUD EPSI      //////////////////////////
/////////////////////////        MODELO REPORTE     ////////////////////////////
/////////////////////////  DEPARTAMENTO DE DESARROLLO  /////////////////////////
////////////////////////////////////////////////////////////////////////////////
//Incluimos inicialmete la conexion a la base de datos
require '../config/Conexion.php';

class ReporteAutorizacion {

    //Implementamos nuestro constructor
    public function __construct() {
        //se deja vacio para implementar instancias hacia esta clase
        //sin enviar parametro
    }

    /**
     * Metodo que obtiene las autorizaciones AU, NC y NP resumidas por año
     * @return obj
     */
    public function get_resumen_aut() {

        $sql = "SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED "
                . "SELECT YEAR(AUT.FEC_AUTORIZACION) VIGENCIA, COUNT(AUT.NO_SOLICITUD) AS TOTAL_REGISTROS "
                . "FROM AUTORIZACION AUT WITH (NOLOCK)  "
                . "WHERE AUT.ESTADO IN ('AU','NC','NP') "
                . "AND AUT.FEC_AUTORIZACION BETWEEN CONVERT(DATE,'2016-01-01 00:00:00.000') AND GETDATE() "
                . "AND EXISTS (SELECT AFS.IDORDENITEM FROM AFILIADOSSUB AFS WHERE AFS.IDORDENITEM = AUT.AUT_IDORDENITEM) "
                . "GROUP BY YEAR(AUT.FEC_AUTORIZACION)";

        return ejecutarConsulta($sql);
    }

    /**
     * Metodo que obtiene las autorizaciones AU, NC y NP
     * @return obj
     */
    public function get_autorizaciones() {

        $sql = "SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED "
                . "SELECT PRE.NOM_PRESTADOR, AUT.NR_IDENT_PREST_IPS, COUNT(AUT.NO_SOLICITUD) AS TOTAL_REGISTROS "
                . "FROM AUTORIZACION AUT WITH (NOLOCK)  "
                . "LEFT JOIN PRESTADORES PRE ON PRE.NIT_PRESTADOR = AUT.NR_IDENT_PREST_IPS  "
                . "WHERE AUT.ESTADO IN ('AU','NC','NP') "
                . "AND AUT.FEC_AUTORIZACION BETWEEN CONVERT(DATE,'2016-01-01 00:00:00.000') AND GETDATE() "
                . "AND EXISTS (SELECT AFS.IDORDENITEM FROM AFILIADOSSUB AFS WHERE AFS.IDORDENITEM = AUT.AUT_IDORDENITEM) "
                . "GROUP BY  PRE.NOM_PRESTADOR, AUT.NR_IDENT_PREST_IPS "
                . "ORDER BY TOTAL_REGISTROS DESC";

        return ejecutarConsulta($sql);
    }

    /**
     * Metodo que obtiene las autorizaciones AU, NC y NP con anticipos
     * @return obj
     */
    public function get_autorAnt() {

        $sql = "SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED "
                . "SELECT PRE.NOM_PRESTADOR, AUT.NR_IDENT_PREST_IPS, COUNT(AUT.NO_SOLICITUD) AS TOTAL_REGISTROS "
                . "FROM AUTORIZACION AUT WITH (NOLOCK)  "
                . "LEFT JOIN PRESTADORES PRE ON PRE.NIT_PRESTADOR = AUT.NR_IDENT_PREST_IPS  "
                . "WHERE AUT.ESTADO IN ('AU','NC','NP') "
                . "AND AUT.FEC_AUTORIZACION BETWEEN CONVERT(DATE,'2016-01-01 00:00:00.000') AND GETDATE() "
                . "AND EXISTS (SELECT AFS.IDORDENITEM FROM AFILIADOSSUB AFS WHERE AFS.IDORDENITEM = AUT.AUT_IDORDENITEM) "
                . "AND AUT.CLS_AUTORIZACION = '1' "
                . "GROUP BY  PRE.NOM_PRESTADOR, AUT.NR_IDENT_PREST_IPS "
                . "ORDER BY TOTAL_REGISTROS DESC";

        return ejecutarConsulta($sql);
    }

    /**
     * Metodo que obtiene la sabana de las autorizaciones AU, NC y NP
     * @return obj
     */
    public function get_data_autorizaciones() {

        $sql = "SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED "
                . "SELECT AUT.NO_SOLICITUD ,AUT.NO_AUTORIZACION, AUT.NUM_CONTRATO, CONVERT(VARCHAR,AUT.FEC_AUTORIZACION,103) F_INI_VIGENCIA, "
                . "CONVERT(VARCHAR,AUT.FEC_VENCIMIENTO,103) F_VENCIMIENTO,  "
                . "AUT.ESTADO, PRE.NOM_PRESTADOR, AUT.NR_IDENT_PREST_IPS,  AUT.TP_IDENT_AFILIA, AUT.NR_IDENT_AFILIA, CEX.DES_CAUSAS, ATU.DES_SERVICIO, CLA.DES_CLASE "
                . "FROM AUTORIZACION AUT WITH (NOLOCK)  "
                . "LEFT JOIN PRESTADORES PRE ON PRE.NIT_PRESTADOR = AUT.NR_IDENT_PREST_IPS  "
                . "LEFT JOIN CAUSA_EXTERNA CEX ON CEX.COD_CAUSAS = AUT.CAUSA_EXTERNA  "
                . "LEFT JOIN AUTUBICACION_SERVICIO ATU ON AUT.COD_UBISERVICIO = ATU.COD_UBISERVICIO  "
                . "LEFT JOIN CLASE_AUTORIZACION CLA ON CLA.COD_CLASE = AUT.CLS_AUTORIZACION "
                . "WHERE AUT.ESTADO IN ('AU','NC','NP') "
                . "AND AUT.FEC_AUTORIZACION BETWEEN CONVERT(DATE,'2016-01-01 00:00:00.000') AND GETDATE() "
                . "AND EXISTS (SELECT AFS.IDORDENITEM FROM AFILIADOSSUB AFS WHERE AFS.IDORDENITEM = AUT.AUT_IDORDENITEM) "
                . "ORDER BY AUT.FEC_AUTORIZACION ASC";

        return ejecutarConsulta($sql);
    }

}
