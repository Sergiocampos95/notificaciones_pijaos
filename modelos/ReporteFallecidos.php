<?php

////////////////////////////////////////////////////////////////////////////////
/////////////////////////       SISTEMA GRAFICAS       /////////////////////////
/////////////////////////      PIJAOS SALUD EPSI      //////////////////////////
/////////////////////////        MODELO REPORTE     ////////////////////////////
/////////////////////////  DEPARTAMENTO DE DESARROLLO  /////////////////////////
////////////////////////////////////////////////////////////////////////////////
//Incluimos inicialmete la conexion a la base de datos
require '../config/Conexion.php';

class ReporteFallecidos {

    //Implementamos nuestro constructor
    public function __construct() {
        //se deja vacio para implementar instancias hacia esta clase
        //sin enviar parametro
    }

    /**
     * Metodo que valida los fallecidos reportados en el archivo de urgencias.
     * @return obj
     */
    public function get_fa_urgencias() {

        $sql = "SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED "
                . "SELECT RIP.TIPO_ENTIDAD, RIP.NUM_ENTIDAD, RIP.COD_PRESTADOR, RIP.NOM_PRESTADOR, RIP.NUM_REMISION, CONVERT(VARCHAR,RIP.FEC_REMISION,103) FEC_REMISION, CONVERT(VARCHAR,RIP.FEC_CARGUE,103) FEC_CARGUE,  "
                . "ARU.TIPO_DOC_USUARIO, ARU.NUM_DOC_USUARIO, CONCAT(AFS.PRI_APELLIDO, ' ', AFS.SEG_APELLIDO, ' ', AFS.PRI_NOMBRE, ' ', AFS.NOM_NOMBRE) NOM_USUARIO, CIU.NOM_CIUDAD, DEP.NOM_DEPARTAMENTO, "
                . "ARU.NUM_FACTURA, ARU.CAUS_MUERTE_URGENCIA, DIA.NOM_DIAGNSOTICO, CONVERT(VARCHAR,ARU.FECHA_SALIDA_OBS,103) FECHA_SALIDA_OBS, ARU.HORA_SALIDA  "
                . "FROM RECEPCIONRIPS RIP WITH (NOLOCK)  "
                . "INNER JOIN ARCH_URGENCIAS ARU ON ARU.COD_PRESTADOR = RIP.COD_PRESTADOR AND ARU.NUM_REMISION = RIP.NUM_REMISION  "
                . "LEFT JOIN DIAGNOSTICOS DIA ON DIA.COD_DIAGNOSTICO = ARU.CAUS_MUERTE_URGENCIA  "
                . "INNER JOIN AFILIADOSSUB AFS ON AFS.NUM_DOCUMENTO_BEN = ARU.NUM_DOC_USUARIO "
                . "INNER JOIN CIUDADES CIU ON AFS.NUM_CIUDAD = CIU.COD_CIUDAD AND AFS.NUM_DEPARTAMENTO = CIU.COD_DEPARTAMENTO   "
                . "INNER JOIN DEPARTAMENTOS DEP ON CIU.COD_DEPARTAMENTO = DEP.COD_DEPARTAMENTO  "
                . "WHERE ARU.ESTADO_SALIDA = '2' AND AFS.EST_AFILIADO = '1'  "
                . "ORDER BY RIP.FEC_CARGUE DESC";

        return ejecutarConsulta($sql);
    }

    /**
     * Metodo que valida los fallecidos reportados en el archivo de hospitalizaciones.
     * @return obj
     */
    public function get_fa_hospitalizaciones() {

        $sql = "SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED "
                . "SELECT RIP.TIPO_ENTIDAD, RIP.NUM_ENTIDAD, RIP.COD_PRESTADOR, RIP.NOM_PRESTADOR, RIP.NUM_REMISION, CONVERT(VARCHAR,RIP.FEC_REMISION,103) AS FEC_REMISION,  "
                . "CONVERT(VARCHAR,RIP.FEC_CARGUE,103) AS FEC_CARGUE, ARH.TIPO_DOC_USUARIO, ARH.NUM_DOC_USUARIO, CONCAT(AFS.PRI_APELLIDO, ' ', AFS.SEG_APELLIDO, ' ', AFS.PRI_NOMBRE, ' ', AFS.NOM_NOMBRE) AS AFILIADO, "
                . "CIU.NOM_CIUDAD, DEP.NOM_DEPARTAMENTO, ARH.NUM_FACTURA, ARH.COD_DIAG_MUERTE, DIA.NOM_DIAGNSOTICO, CONVERT(VARCHAR,ARH.FECHA_EGRE_INST,103) AS FECHA_EGRE_INST, ARH.HORA_EGRESO  "
                . "FROM RECEPCIONRIPS RIP WITH (NOLOCK)  "
                . "INNER JOIN ARCH_HOSPITALIZACION ARH ON ARH.COD_PRESTADOR = RIP.COD_PRESTADOR AND ARH.NUM_REMISION = RIP.NUM_REMISION  "
                . "LEFT JOIN DIAGNOSTICOS DIA ON DIA.COD_DIAGNOSTICO = ARH.COD_DIAG_MUERTE  "
                . "LEFT JOIN AFILIADOSSUB AFS ON AFS.NUM_DOCUMENTO_BEN = ARH.NUM_DOC_USUARIO  "
                . "INNER JOIN CIUDADES CIU ON AFS.NUM_CIUDAD = CIU.COD_CIUDAD AND AFS.NUM_DEPARTAMENTO = CIU.COD_DEPARTAMENTO   "
                . "INNER JOIN DEPARTAMENTOS DEP ON CIU.COD_DEPARTAMENTO = DEP.COD_DEPARTAMENTO  "
                . "WHERE ARH.ESTADO_SALIDA = '2' AND AFS.EST_AFILIADO = '1'  "
                . "ORDER BY RIP.FEC_CARGUE DESC";

        return ejecutarConsulta($sql);
    }

    /**
     * Metodo que valida los afiliados reportados como fallecidos en facturacion 
     * @return type
     */
    public function get_fallecidos_facturacion() {


        $sql = "SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED "
                . "SELECT CTA.TIP_ENTIDAD, CTA.NUM_ENTIDAD, CTA.NOM_ENTIDAD, CTA.COD_RADICACION, CONVERT(VARCHAR,CTA.FEC_RADICACION,103) FEC_RADICACION,   "
                . "CTA.NUM_FACTURA, CTA.NUM_CAJA, CTA.NUM_PAQUETE, AFA.TIP_IDENT_USUAR, AFA.NUR_IDENT_USUAR, AFA.NOM_AFILIADO,  "
                . "CIU.NOM_CIUDAD, DEP.NOM_DEPARTAMENTO, CONVERT(VARCHAR,AFA.FEC_SALIDA,103) FEC_SALIDA   "
                . "FROM AFILATENDIDO AFA WITH (NOLOCK)    "
                . "INNER JOIN CTAAUDITADAS CTA ON CTA.COD_RADICACION = AFA.COD_RADICACION "
                . "INNER JOIN CIUDADES CIU ON AFA.MUN_RES_HABITUAL = CIU.COD_CIUDAD AND AFA.DPT_RES_HABITUAL = CIU.COD_DEPARTAMENTO   "
                . "INNER JOIN DEPARTAMENTOS DEP ON CIU.COD_DEPARTAMENTO = DEP.COD_DEPARTAMENTO    "
                . "WHERE EST_VITAL = '1'   "
                . "AND EXISTS (SELECT AFS.IDORDENITEM FROM AFILIADOSSUB AFS WHERE AFS.IDORDENITEM = AFA.CTA_IDORDENITEM AND AFS.EST_AFILIADO = '1')   "
                . "GROUP BY CTA.TIP_ENTIDAD, CTA.NUM_ENTIDAD, CTA.NOM_ENTIDAD, CTA.COD_RADICACION, CTA.FEC_RADICACION, CTA.NUM_FACTURA,  "
                . "CTA.NUM_CAJA, CTA.NUM_PAQUETE, AFA.TIP_IDENT_USUAR, AFA.NUR_IDENT_USUAR, AFA.NOM_AFILIADO, CIU.NOM_CIUDAD, DEP.NOM_DEPARTAMENTO, AFA.FEC_SALIDA    "
                . "ORDER BY CTA.COD_RADICACION DESC";

        return ejecutarConsulta($sql);
    }

}
