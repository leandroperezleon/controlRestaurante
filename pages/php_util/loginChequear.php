<?php

/*Las funciones PHP que modifican las cabeceras HTTP son las siguientes:
 header()        / header_remove()
 session_start() / session_regenerate_id()
 setcookie()     / setrawcookie()
 
require(«ruta/archivo.php»)        requerido envia error
include(«ruta/archivo.php»)         envia warning
require_once(«ruta/archivo.php»)    mas pesada
include_once(«ruta/archivo.php»)    mas pesada
*/

ob_start();
require ('conexion.php');

// declara variables y constantes globales
const PREFIJO = 'AWR004z5o8Ub6Fb8hM4Qijy5UyJn736t';
const SUFIJO =  'qYfd010Ca4UGPUA6MY6pY51Zklv7GVjY';

try {
    
    // realiza la conexion
    $conexion = mConectar();
    if ($conexion==null) 
    {   die("La conexion fallo: " . $conexion->connect_error);
        exit();
    }
    
    // establece variables de login
    $username =$_REQUEST['txtUsername'];
    $clave    =$_REQUEST['txtClave'];
    $clave = PREFIJO.$clave.SUFIJO;
    
    $result = $conexion->query("SELECT  us.id_usuario,
                                us.id_empresa,
                                us.id_rol,
                                us.clave
                                FROM usuarios us
                                inner join  empresa em on us.id_empresa = em.id_empresa
                                WHERE us.username = '$username'
                                    and us.estado='1'
                                    and em.estado = '1' limit 1") or die("Problemas en el select:".$conexion->error);
    $reg = $result->fetch_array();
    
    // analiza resultado
    if($reg == null)
    {   echo "Usuario no esta registrado.";
        echo "<br><a href='../../index.html'>Volver a Intentarlo</a>";
        exit;
    }
            
    // el registro existe solo que no tiene clave, es primer ingreso la clave que ingrese se estable como la clave del usuario ingresado
    if(strlen(trim($reg['clave']))==0)
    {
        $claveCifrada  = password_hash($clave, PASSWORD_BCRYPT,['cost' => 10]);
        //$claveCifrada = mysqli_real_escape_string($conexion,(strip_tags($claveCifrada,ENT_QUOTES)));
        $conexion->query("  UPDATE usuarios
                            SET clave = '$claveCifrada'
                            WHERE username = '$username'
                                and estado = '1'
                                and id_empresa = ". $reg['id_empresa']) or die("Problemas en el select:".$conexion->error);
        echo "Password ha sido creado correctamente.";
        echo "<br><a href='../../index.html'>Volver a logonear</a>";
        exit;
    }
        
    // el usuario ya tiene clave creada 
    // clave no es correcta
    if(!password_verify($clave, $reg['clave']))
    {   echo "Username o Password estan incorrectos.";
        echo "<br><a href='../../index.html'>Volver a Intentarlo</a>";
        exit;
    }
    
    // clave correcta
    session_start();
    $_SESSION['loggedin'] = true;
    $_SESSION['start'] = time();
    $_SESSION['expire'] = $_SESSION['start'] + (7 * 60);
    $_SESSION['idusuario'] = $reg['id_usuario'];
    $_SESSION['idempresa'] = $reg['id_empresa'];
    $_SESSION['idrol'] = $reg['id_rol'];
    $_SESSION['username'] = $username;
    $_SESSION['servidor'] =SERVIDOR;
    
    header(SERVIDOR.'pages/php/principal.php');//redirecciona a la pagina del usuario     
    
} 
catch (Exception $e) {
    die("codeError-> ".$e->getCode()." mensajeError-> ". $e->getMessage());
    return null;    
}
finally {
    mDesconectar($conexion);
}

ob_end_flush();
?>