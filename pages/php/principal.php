<?php
ob_start();
include '../php_util/parametros.php';

session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) 
{
    echo "Inicia Sesion para acceder a este contenido.<br>";
    echo "<br><a href='../../index.html'>Login</a>";
    header(SERVIDOR.'index.html'); //redirige a la página de login si el usuario ingresa sin iniciar sesion
    exit;
}

$now = time();
if($now > $_SESSION['expire']) 
{
    session_destroy();   
    echo "Tu sesion a expirado, <a href='../../index.html'>Inicia Sesion</a>";
    header(SERVIDOR.'index.html');//redirige a la página de login, modifica la url a tu conveniencia
    exit;
}

ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Control Almuerzos</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../css/estilos_formulario.css" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

    <div class="jumbotron text-center">
      <h1>Bienvenido <?php echo  $_SESSION['username'];?></h1>
      <p>Manten tu perfil actualizado</p> 
      <a href=../php_util/logout.php><button type="button" class="btn btn-success">Cerrar Sesion</button></a>
    </div>
  
    <div class="container">
      <div class="row">
      	<?php      	 
      	 
  	     include '../php_util/conexion.php';  	           	     
  	     $conexion = mConectar();
  	     if ($conexion==null || $conexion->connect_error ) {
  	         die("La conexion fallo: " . $conexion->connect_error);
  	     }
  	             	     
  	     $result = $conexion->query(" select mn.nombre_pagina,
                                      mn.etiqueta,
                              	      mn.ayuda_opcion
                              	      from menu mn
                              	      inner join menu_x_rol mnr on mn.id_menu = mnr.id_menu
                              	      where id_empresa= ".$_SESSION['idempresa']."
                              	      and mnr.id_rol =  ".$_SESSION['idrol']."
                              	      and mn.estado = '1'
                              	      order by orden") or die("Problemas en el select:".$conexion->error);
  	     while($row = mysqli_fetch_array($result))
  	     {
  	         
  	     ?>
  	       	<div class="col-sm-3" >
              <a href="<?php echo $row['nombre_pagina']?>"><h3><?php echo $row['etiqueta']?> </h3></a>
              <p><?php echo $row['ayuda_opcion']?></p>
            </div>
  	     <?php 
  	         
  	     }     	     
  	     mDesconectar($conexion);   	  
      	
      	?>       
      </div>
    </div>
</body>
</html>