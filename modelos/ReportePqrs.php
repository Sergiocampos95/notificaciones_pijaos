 <?php
//  #####################################
//  #####################################
//  #########  ENVIO DE EMAILS ##########
//  ######### PQRSF DE LA EPSI ##########
//  #####################################
 require '../config/Conexion.php';

 class ReportePqrs {

    public function __construct() {
    // SE DEJA VACIO PARA IMPLEMENTAR INSTANCIAS  HACIA ESTA CLASE
    }

    //METODO ENCARGADO DE RETORNAR LOS DATOS DE LA PQRS DE LA PERSONA
    public function getPqrsEmail() {
      $sql = "SELECT CORREOEMAIL, ENVIO_EMAIL, CONSECUTIVO, PRI_NOMBRE, SEG_NOMBRE, PRI_APELLIDO, "
           . "SEG_APELLIDO, TP_DOC_AFI,NM_DOC_AFI, TELEFONO, CELULAR1, DETALLE, COD_AREA_REF FROM QUEJAS WHERE ENVIO_EMAIL = 0";

      return ejecutarConsultaSimpleFila($sql);
    }

    //METODO ENCARGADO DE ACTUALIZAR LA PQRS A 1 PARA SABER QUE YA FUE ENVIADO
    public function actualizarQuejaEnvio($consecutivo) {
     $sql = "UPDATE QUEJAS SET ENVIO_EMAIL = 1 WHERE CONSECUTIVO = $consecutivo";
     return ejecutarConsulta($sql);
    }
 }