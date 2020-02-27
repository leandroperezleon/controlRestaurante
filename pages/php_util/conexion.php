<?php
require_once('../php_util/parametros.php');
// local
if(LOCAL=='S')
{   define('DB_HOST','localhost');
    define('DB_USER','root');
    define('DB_PASS','adminbd1');
    define('DB_NAME','restaurante');
}
// servidor
else
{   define('DB_HOST','localhost');
    define('DB_USER','robocate_root');
    define('DB_PASS','+aHl;R6H60jjY9');
    define('DB_NAME','robocate_controlRestaurante');    
}

function mConectar()
{
    try {
        $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS,DB_NAME);
        
        /*verifico si hubo error de conexion*/
        if ($conexion->connect_error)
        {	die("Conexión falló: ".$conexion->connect_errno." : ". $conexion->connect_error);
            return null;
        }
        return $conexion;
    } catch (Exception $e) {
        die("codeError-> ".$e->getCode()." mensajeError-> ". $e->getMessage());
        return null;
    }
    
}/*mConectar*/

function mDesconectar($conexion)
{
    $conexion->close();
}/*mDesconectar*/

?>