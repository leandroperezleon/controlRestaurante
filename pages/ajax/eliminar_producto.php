<?php
	if (empty($_POST['delete_id']))
	{
		$errors[] = "Id vacío.";
	} 
	elseif (!empty($_POST['delete_id']))
	{
	   require_once ("../php_util/conexion.php");//Contiene funcion que conecta a la base de datos
	   $conexion = mConectar();
	   
	   // escaping, additionally removing everything that could be (html/javascript-) code
	   $id_producto=intval($_POST['delete_id']);	  
       
       // DELETE FROM  database
       $sql = "DELETE FROM productos WHERE id_producto='$id_producto'";
       $query = $conexion->query($sql);
        
       // if product has been added successfully
       if ($query) 
       {
           $messages[] = "El producto ha sido eliminado con &eacute;xito.";
       } else 
       {
           $errors[] = "Lo sentimos, la eliminación fall&oacute;. Por favor, regrese y vuelva a intentarlo.";
       }
        	
    } 
    else 
	{
		$errors[] = "desconocido.";
	}
    	
    if (isset($errors))
    {			
?>
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Error!</strong> 
				<?php
					foreach ($errors as $error) {
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