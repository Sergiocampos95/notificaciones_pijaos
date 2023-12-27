<?php

////////////////////////////////////////////////////////////////////////////////
/////////////////////////       SISTEMA GEMA_WEB       /////////////////////////
/////////////////////////      PIJAOS SALUD EPSI      //////////////////////////
/////////////////////////  CONEXION A LA BASE DE DATOS   ///////////////////////
/////////////////////////  DEPARTAMENTO DE DESARROLLO  /////////////////////////
///////       CONEXION A LA BASE DE DATOS Y METODOS GENERALES SQL     //////////
////////////////////////////////////////////////////////////////////////////////


require_once 'global.php';

$conn = array("Database" => DB_NAME, "UID" => DB_USERNAME, "PWD" => DB_PASSWORD, "CharacterSet" => DB_ENCODE);

$conexion = sqlsrv_connect(DB_HOST, $conn);

if ($conexion) {

    //echo 'Conexión establecida.';
} else {

    echo 'Conexión no se pudo establecer. <br>';
    die(print_r(sqlsrv_errors(), true));
}


//si no existe la funcion de consulta, la definimos
if (!function_exists('ejecutarConsulta')) {

    function ejecutarConsulta($sql) {

        global $conexion;
        $query = sqlsrv_query($conexion, $sql);
        return $query;
    }

    //retorna en una fila el resultado de una consulta
    function ejecutarConsultaSimpleFila($sql) {

        global $conexion;
        $query = sqlsrv_query($conexion, $sql);
        $row = sqlsrv_fetch_object($query);
        return $row;
    }

    //limpia caracteres especiales antes de consultar
    function limpiarCadena($str) {

        $str = trim($str);
        $str = stripcslashes($str);
        $str = htmlspecialchars($str);

        return $str;
    }

    /**
     * Metodo que des encripta una cadena
     * @param string $data
     * @param string $key
     */
    function decrypt($data, $key = "PIJAOS_2023") {

        list($encrypted_data, $clave_temporal) = explode('::', base64_decode($data), 2);

        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $clave_temporal);
    }

################################################################################
#####    DESCOMENTAR EN CASO DE CAMBIAR LA CLAVE DEL CORREO ELECTRONICO    #####
################################################################################

    /**
     * Metodo que encripta una cadena dinamica
     * @param string $data
     * @param string $key
     */
//    public function encrypt($data, $key) {
//        $clave_temporal = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
//        $encrypted = openssl_encrypt($data, "aes-256-cbc", $key, 0, $clave_temporal);
//        // Retorno de la clave con el id temporal 
//        return base64_encode($encrypted . "::" . $clave_temporal);
//    }
}


//$key = "";
//$string = "";
//
//$encryptado = encrypt($string, $key);
//echo $encryptado;
//echo "<hr>";
//echo decrypt($encryptado, $key);
 