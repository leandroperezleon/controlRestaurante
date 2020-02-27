<?php

    if (empty($_POST['nombreProducto']) || empty($_POST['nombreCortoProducto']) || empty($_POST['precio']))
    {
        if (empty($_POST['nombreProducto']))
            $errors[] = "Ingresa nombre del producto.";
        if (empty($_POST['nombreCortoProducto']))
            $errors[] = "Ingresa nombre corto del producto.";
        if (empty($_POST['precio']))
           $errors[] = "Ingresa precio del producto.";
        
    }	
    elseif (!empty($_POST['nombreProducto']) && !empty($_POST['nombreCortoProducto']) && !empty($_POST['precio']))
	{
    	require_once ("../php_util/conexion.php");//Contiene funcion que conecta a la base de datos
    	$conexion = mConectar();
    	
    	// escaping, additionally removing everything that could be (html/javascript-) code
    	$pro_nombre_producto = mysqli_real_escape_string($conexion,(strip_tags($_POST["nombreProducto"],ENT_QUOTES)));
    	$pro_nombre_corto_producto = mysqli_real_escape_string($conexion,(strip_tags($_POST["nombreCortoProducto"],ENT_QUOTES)));
    	$pro_precio = doubleval($_POST["precio"]);
    	$pro_estado=1;
    	$pro_fechaIngreso=date("Y-m-d H:i:s");
    	$pro_usuarioIngreso="fcontreras";
    	
    	$revisar = getimagesize($_FILES["idFileProducto"]["tmp_name"]);
    	// addslashes para escapar cadena
    	if($revisar != false && $revisar != null){
    	    $imgNombre=addslashes($_FILES['idFileProducto']['name']);
    	    $imgContenido = addslashes(file_get_contents($_FILES['idFileProducto']['tmp_name']));
    	    $imgType=addslashes($_FILES['idFileProducto']['type']);
    	} 
    	else{    
    	    $imgContenido ="";
    	    $errors[] = "Lo sentimos, debe cargar una imagen de producto.";
    	}
    	
    	    
    	if (!isset($errors))
    	{
    	    // REGISTER data into database
    	    $sql = "INSERT INTO productos (nombre_producto,nombre_corto_producto,estado,precio,fecha_ingreso,usuario_ingreso,imagen,mime)
                 VALUES ('$pro_nombre_producto','$pro_nombre_corto_producto','$pro_estado',$pro_precio,'$pro_fechaIngreso','$pro_usuarioIngreso','$imgContenido','$imgType')";
    	    $query = $conexion->query($sql);
    	    // if client has been added successfully
    	    if ($query)
    	    {
    	        $messages[] = "El producto ha sido guardado con &eacute;xito.";
    	    }
    	    else
    	    {
    	        $errors[] = "Lo sentimos, el registro fall&oacute;. Por favor, regrese y vuelva a intentarlo.";
    	    }    	    
    	}   	
        
        // desconectar
        mDesconectar($conexion);
    	
	} else 
	{
		$errors[] = "desconocido.";
	}
    
	// control error
    if (isset($errors))
    {
?>
	<div class="alert alert-danger" role="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Error!</strong> 
			<?php
				foreach ($errors as $error) 
				{
					echo $error;
				}
			?>
    </div>

<?php
    }

	if (isset($messages))
	{
?>
		<div class="alert alert-success" role="alert">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>¡Bien hecho!</strong>
			<?php
				foreach ($messages as $message) {
						echo $message;
					}
			?>
		</div>
<?php
	}
?>