<?php
////////////////////////////////////////////////////////////////////////////////
/////////////////////////       SISTEMA GRAFICAS       /////////////////////////
/////////////////////////      PIJAOS SALUD EPSI      //////////////////////////
/////////////////////////        MODELO REPORTE     ////////////////////////////
/////////////////////////  DEPARTAMENTO DE DESARROLLO  /////////////////////////
////////////////////////////////////////////////////////////////////////////////
//Incluimos inicialmete la conexion a la base de datos
require '../config/Conexion.php';
class ReporteLbancario {
  //Implementamos nuestro constructor
  public function __construct() {
    //se deja vacio para implementar instancias hacia esta clase
    //sin enviar parametro
  }
  /**
  * Metodo que valida el log de registros bancarios vs pilas agrupado por a�o.
  * @return obj
  */
  public function get_resumenLog() {
    $sql  = "DECLARE @FEC_FILTRO DATETIME "
          . "SELECT @FEC_FILTRO = [dbo].[Fnc_Dias_Restar] (-3, GETDATE(), 1, 1, 1, 1, 1, 0, 0, 0) "
          . "SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED  "
          . "SELECT YEAR(RBE.RBE_FEC_RECAUDO) FEC_RECAUDO, COUNT(RBE.RBE_ID_CONSEC) TOTAL_REGISTROS  "
          . "FROM REC_BANCOS_ENCAB RBE WITH (NOLOCK)   "
          . "LEFT OUTER JOIN REC_BANCOS_DETALLE RBD ON RBE.RBE_ID_CONSEC = RBD.RBD_ID_CONSEC  "
          . "WHERE  RBD.EAP_ID_CONSEC_PILA IS NULL AND RBE.RBE_FEC_RECAUDO <= @FEC_FILTRO  "
          . "GROUP BY YEAR(RBE.RBE_FEC_RECAUDO)";

    return ejecutarConsulta($sql);
  }
  /**
  * Metodo que valida el log de registros bancarios vs pilas.
  * @return obj
  */
  public function get_logHistorico() {
    $sql = "DECLARE @FEC_FILTRO DATETIME "
         . "SELECT @FEC_FILTRO = [dbo].[Fnc_Dias_Restar] (-3, GETDATE(), 1, 1, 1, 1, 1, 0, 0, 0) "
         . "SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED "
         . "SELECT RBE.RBE_ID_CONSEC, RBE.RBE_ID_REGISTRO, CONVERT(VARCHAR,RBE.RBE_FEC_RECAUDO,103) RBE_FEC_RECAUDO, RBE.RBE_COD_RECEPTORA, "
         . "RBE.RBE_NIT_ADMIN, RBE.RBE_NOMBRE_ADMIN, RBE.RBE_RESERVADO, RBE.RBE_NOM_ARCHIVO, CONVERT(VARCHAR,RBE.RBE_FEC_CARGUE,103) RBE_FEC_CARGUE, "
         . "RBE.RBE_USU_CARGUE, RBD.RBD_ID_CONSEC, RBD.RBD_ID_REGISTRO, RBD.RBD_ID_APORTANTE, RBD.RBD_NOM_APORTANTE, RBD.RBD_COD_BANCO, RBD.RBD_NRO_PLANILLA, "
         . "CONVERT(VARCHAR,RBD.RBD_PERIODO_PAGO,103) RBD_PERIODO_PAGO, RBD.RBD_CANAL_PAGO, RBD.RBD_NRO_REGISTROS, RBD.RBD_COD_OPERADOR, RBD.RBD_VALOR_PLANILLA, "
         . "RBD.RBD_HORA_MINUTO, RBD.RBD_NRO_SECUENCIA, RBD.RBD_APO_IDEMPRESA, RBD.RBD_RESERVADO, RBD.RBD_NRO_ERROR, RBD.RBD_ESTADO, RBD.EAP_ID_CONSEC_PILA "
         . "FROM REC_BANCOS_ENCAB RBE WITH (NOLOCK)  "
         . "LEFT OUTER JOIN REC_BANCOS_DETALLE RBD ON RBE.RBE_ID_CONSEC = RBD.RBD_ID_CONSEC "
         . "WHERE  RBD.EAP_ID_CONSEC_PILA IS NULL AND RBE.RBE_FEC_RECAUDO <= @FEC_FILTRO "
         . "ORDER BY RBE.RBE_FEC_CARGUE ASC";

    return ejecutarConsulta($sql);
  }
}