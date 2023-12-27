<?php

////////////////////////////////////////////////////////////////////////////////
/////////////////////////       SISTEMA GRAFICAS       /////////////////////////
/////////////////////////      PIJAOS SALUD EPSI      //////////////////////////
/////////////////////////        MODELO REPORTE     ////////////////////////////
/////////////////////////  DEPARTAMENTO DE DESARROLLO  /////////////////////////
////////////////////////////////////////////////////////////////////////////////
//Incluimos inicialmete la conexion a la base de datos
require '../config/Conexion.php';

class ReporteActDocumento {

    //Implementamos nuestro constructor
    public function __construct() {
        //se deja vacio para implementar instancias hacia esta clase
        //sin enviar parametro
    }

    /**
     * Metodo que obtiene los registros de afiliados con documentos CN, RC, y TI pendientes por actualizar
     * @return obj
     */
    public function get_resumenTP() {

        $sql = "SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED "
                . "SELECT AFS.TIP_DOCUMENTO_BEN, COUNT(TIP_DOCUMENTO_BEN) AS TOTAL_REGISTROS "
                . "FROM AFILIADOSSUB AFS WITH (NOLOCK)  "
                . "WHERE AFS.EST_AFILIADO = '1'  "
                . "AND( "
                . "	([DBO].[EDAD_ANIOS](FEC_NACIMIENTO, GETDATE()) >= 7 AND TIP_DOCUMENTO_BEN = 'RC' AND FORMAT(FEC_NACIMIENTO, 'dd-MM') <> FORMAT(GETDATE(), 'dd-MM')) OR "
                . "	([DBO].[EDAD_ANIOS](FEC_NACIMIENTO, GETDATE()) >= 18 AND TIP_DOCUMENTO_BEN = 'TI' AND FORMAT(FEC_NACIMIENTO, 'dd-MM') <> FORMAT(GETDATE(), 'dd-MM')) OR "
                . "	(DATEDIFF(MONTH,AFS.FEC_NACIMIENTO, CAST(GETDATE() AS DATE)) > 3 AND AFS.TIP_DOCUMENTO_BEN = 'CN')  "
                . ") "
                . "GROUP BY AFS.TIP_DOCUMENTO_BEN "
                . "ORDER BY AFS.TIP_DOCUMENTO_BEN ASC";

        return ejecutarConsulta($sql);
    }

    /**
     * Metodo que obtiene la sabana de registros de afiliados con documentos CN, RC, y TI pendientes por actualizar
     * @param type $tipo_consulta
     * @return obj
     */
    public function get_dataTP($tipo_consulta) {


        switch ($tipo_consulta) {
            //Consulta documentos por CN
            case 1:
                $cadena = "(DATEDIFF(MONTH,AFS.FEC_NACIMIENTO, CAST(GETDATE() AS DATE)) > 3 AND AFS.TIP_DOCUMENTO_BEN = 'CN')";
                break;

            //Consulta de documento por RC
            case 2:
                $cadena = "([DBO].[EDAD_ANIOS](FEC_NACIMIENTO, GETDATE()) >= 7 AND TIP_DOCUMENTO_BEN = 'RC' AND FORMAT(FEC_NACIMIENTO, 'dd-MM') <> FORMAT(GETDATE(), 'dd-MM'))";
                break;

            //Consulta documentos por TI
            case 3:
                $cadena = "([DBO].[EDAD_ANIOS](FEC_NACIMIENTO, GETDATE()) >= 18 AND TIP_DOCUMENTO_BEN = 'TI' AND FORMAT(FEC_NACIMIENTO, 'dd-MM') <> FORMAT(GETDATE(), 'dd-MM'))";
                break;
        }


        $sql = "SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED "
                . "SELECT   "
                . "AFS.TIP_DOCUMENTO_BEN AS TIPDOC_AFILIADO,  "
                . "AFS.NUM_DOCUMENTO_BEN AS NUMDOC_AFILIADO,  "
                . "AFS.PRI_APELLIDO,  "
                . "AFS.SEG_APELLIDO,  "
                . "AFS.PRI_NOMBRE,  "
                . "AFS.NOM_NOMBRE AS SEG_NOMBRE, "
                . "CONVERT(VARCHAR, AFS.FEC_NACIMIENTO, 103) AS FEC_NACIMIENTO,  "
                . "[DBO].[EDAD_COMPLETA] (AFS.FEC_NACIMIENTO, GETDATE()) AS EDAD, "
                . "AFS.TIP_DOCUMENTO_COT AS TIPDOC_COTIZANTE,  "
                . "AFS.NUM_DOCUMENTO_COT AS NUMDOC_COTIZANTE, "
                . "DEP.NOM_DEPARTAMENTO AS DEPARTAMENTO, "
                . "CIU.NOM_CIUDAD AS MUNICIPIO, "
                . "AFS.DIR_RESIDENCIA AS DIRECCION, "
                . "AFS.TEL_MOVIL AS TELEFONO_1, "
                . "AFS.TEL_MOVIL2 AS TELEFONO_2, "
                . "AFS.EMAIL, "
                . "CONVERT(VARCHAR, AFS.FEC_AFILIACIONARS, 103) AS FEC_AFILIACION, "
                . "CASE "
                . "	WHEN SUBSTRING (AFS.CODCTROCOSTOS, 1, 1) = 'C' THEN 'CONTRIBUTIVO' "
                . "	ELSE 'SUBSIDIADO' "
                . "END AS REGIMEN, "
                . "GRP.NOM_GRUPO AS TIPO_POBLACION "
                . "FROM AFILIADOSSUB AFS WITH (NOLOCK) "
                . "INNER JOIN CIUDADES CIU ON AFS.NUM_CIUDAD = CIU.COD_CIUDAD AND AFS.NUM_DEPARTAMENTO = CIU.COD_DEPARTAMENTO  "
                . "INNER JOIN DEPARTAMENTOS DEP ON CIU.COD_DEPARTAMENTO = DEP.COD_DEPARTAMENTO "
                . "INNER JOIN GRUPO_POBLACION GRP ON AFS.GRU_POBLACONAL = GRP.COD_GRUPO  "
                . "WHERE AFS.EST_AFILIADO = '1'  "
                . "AND(" . $cadena . ") "
                . "ORDER BY AFS.TIP_DOCUMENTO_BEN, AFS.FEC_NACIMIENTO ASC ";

        return ejecutarConsulta($sql);
    }

}
