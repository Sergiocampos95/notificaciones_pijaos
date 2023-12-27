<?php

////////////////////////////////////////////////////////////////////////////////
/////////////////////////       SISTEMA GRAFICAS       /////////////////////////
/////////////////////////      PIJAOS SALUD EPSI      //////////////////////////
/////////////////////////        MODELO REPORTE     ////////////////////////////
/////////////////////////  DEPARTAMENTO DE DESARROLLO  /////////////////////////
////////////////////////////////////////////////////////////////////////////////
//Incluimos inicialmete la conexion a la base de datos
require '../config/Conexion_fm.php';

class ReporteMipres {

    //Implementamos nuestro constructor
    public function __construct() {
        //se deja vacio para implementar instancias hacia esta clase
        //sin enviar parametro
    }

    /**
     * Metodo que valida los direccionamientos de un prestador para el a�o 2020
     * @param date $periodo1
     * @param date $periodo2
     * @param int $tipo_consulta
     * @return obj
     */
    public function get_direccionamientos($periodo1, $periodo2) {

        $sql = "SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED SELECT "
                . "TIPOIDPROV, NOIDPROV, NOMPROV, COUNT(NOPRESCRIPCION) AS T_SIN_REPORTE "
                . "FROM FACMIPRES WITH (NOLOCK) "
                . "WHERE FECMAXENT < GETDATE() "
                . "AND IDREPORTEENTREGA IS NULL "
                . "AND IDSUMINISTRO IS NULL "
                . "AND FECMAXENT >= '$periodo1' "
                . "AND FECMAXENT <= '$periodo2' "
                . "AND DIR_NODIR LIKE 'DIRECCIONAMIENTO' "
                . "GROUP BY TIPOIDPROV, NOIDPROV, NOMPROV ORDER BY T_SIN_REPORTE DESC ";


        return ejecutarConsulta($sql);
    }

    /**
     * Metodo que retorna el total de prescripciones con reporte de entrega de un prestador
     * @param String $num_prestador
     * @return obj
     */
    public function get_count_re($num_prestador, $periodo1, $periodo2) {

        $sql = "SELECT COUNT(NOPRESCRIPCION) AS T_CON_REPORTE FROM FACMIPRES"
                . "WHERE NOIDPROV = '$num_prestador' "
                . "AND FECMAXENT < GETDATE() "
                . "AND IDREPORTEENTREGA IS NOT NULL  "
                . "AND IDSUMINISTRO IS NOT NULL "
                . "AND FECMAXENT >= '$periodo1' "
                . "AND FECMAXENT <= '$periodo2' "
                . "AND DIR_NODIR LIKE 'DIRECCIONAMIENTO' ";

        return ejecutarConsulta($sql);
    }

    /**
     * Metodo que obtiene la sabana de trazabilidad solo con los direccionamientos
     * @return obj
     */
    public function get_data_direccionamientos($periodo1, $periodo2) {

        $sql = "SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED "
                . "SELECT * FROM FACMIPRES WITH (NOLOCK)  "
                . "WHERE FECMAXENT < GETDATE() "
                . "AND IDREPORTEENTREGA IS NULL "
                . "AND IDSUMINISTRO IS NULL "
                . "AND FECMAXENT >= '$periodo1' "
                . "AND FECMAXENT <= '$periodo2' "
                . "AND DIR_NODIR LIKE 'DIRECCIONAMIENTO'  "
                . "ORDER BY FECMAXENT ASC ";

        return ejecutarConsulta($sql);
    }

    /**
     * Metodo que obtiene la sabana de trazabilidad solo con los direccionamientos de urgencias y hospitalizaciones
     * @return obj
     */
    public function get_direUH($periodo1, $periodo2) {

        $sql = "SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED "
                . "SELECT TIPOIDIPS, NROIDIPS, NOMIDIPS, COUNT(NOPRESCRIPCION) AS T_SIN_REPORTE "
                . "FROM FACMIPRES WITH (NOLOCK) WHERE "
                . "FPRESCRIPCION >= '$periodo1' AND FPRESCRIPCION <= '$periodo2'  "
                . "AND DESAMBATE IN ('HOSPITALARIO – INTERNACION', 'HOSPITALARIO – INTERNACION', 'URGENCIAS') "
                . "AND EST_PRES_TUT NOT LIKE 'ANULADO' "
                . "AND ESTJM IN ('EVALUADA POR LA JUNTA DE PROFESIONALES Y FUE APROBADA', 'NO REQUIERE JUNTA DE PROFESIONALES') "
                . "AND IDREPORTEENTREGA IS NULL "
                . "AND IDSUMINISTRO IS NULL "
                . "AND IDDIR_IDNODIR IS NULL "
                . "AND NOMIDIPS IS NOT NULL "
                . "GROUP BY TIPOIDIPS, NROIDIPS, NOMIDIPS  "
                . "ORDER BY T_SIN_REPORTE DESC ";

        return ejecutarConsulta($sql);
    }

    /**
     * Metodo que retorna el total de prescripciones con reporte de entrega de un prestador en UH
     * @param String $num_prestador
     * @param date $periodo1
     * @param date $periodo2
     * @return obj
     */
    public function get_count_reUH($num_prestador, $periodo1, $periodo2) {

        $sql = "SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED "
                . "SELECT COUNT(NOPRESCRIPCION) AS T_CON_REPORTE "
                . "FROM FACMIPRES WITH (NOLOCK) WHERE "
                . "FPRESCRIPCION >= '$periodo1' "
                . "AND FPRESCRIPCION <= '$periodo2' "
                . "AND DESAMBATE IN ('HOSPITALARIO – INTERNACION', 'HOSPITALARIO – INTERNACION', 'URGENCIAS') "
                . "AND EST_PRES_TUT NOT LIKE 'ANULADO' AND ESTJM IN ('EVALUADA POR LA JUNTA DE PROFESIONALES Y FUE APROBADA', 'NO REQUIERE JUNTA DE PROFESIONALES') "
                . "AND IDREPORTEENTREGA IS NOT NULL "
                . "AND IDSUMINISTRO IS NOT NULL "
                . "AND IDDIR_IDNODIR IS NULL "
                . "AND NROIDIPS LIKE '$num_prestador' ";

        return ejecutarConsulta($sql);
    }

    /**
     * Metodo que obtiene la sabana de trazabilidad solo con los direccionamientos de urgencias y hospitalizaciones
     * @return obj
     */
    public function get_data_direUH($periodo1, $periodo2) {


        $sql =  "SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED "
                . "SELECT * FROM FACMIPRES WITH (NOLOCK)  "
                . "WHERE  "
                . "FPRESCRIPCION >= '$periodo1' "
                . "AND FPRESCRIPCION <= '$periodo2'  "
                . "AND DESAMBATE IN ('HOSPITALARIO – INTERNACION', 'HOSPITALARIO – DOMICILIARIO', 'URGENCIAS') "
                . "AND EST_PRES_TUT NOT LIKE 'ANULADO' "
                . "AND ESTJM IN ('EVALUADA POR LA JUNTA DE PROFESIONALES Y FUE APROBADA', 'NO REQUIERE JUNTA DE PROFESIONALES') "
                . "AND IDREPORTEENTREGA IS NULL "
                . "AND IDSUMINISTRO IS NULL "
                . "AND IDDIR_IDNODIR IS NULL "
                . "ORDER BY FPRESCRIPCION ASC";

        return ejecutarConsulta($sql);
    }

}
