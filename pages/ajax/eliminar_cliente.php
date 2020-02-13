<?php
    ob_start();
	if (empty($_POST['delete_id']))
	{
		$errors[] = "Id vac�o.";
	} 
	elseif (!empty($_POST['delete_id']))
	{
	   require_once ("../php_util/conexion.php");//Contiene funcion que conecta a la base de datos
	   $conexion = mConectar();
	   
	   $id_cliente=intval($_POST['delete_id']);       
        
       $sql = "DELETE FROM clientes WHERE id_cliente='$id_cliente'";
       $query = $conexion->query($sql);
        
       if ($query) 
       {
           $messages[] = "El cliente ha sido eliminado con &eacute;xito.";
       } else 
       {
           $errors[] = "Lo sentimos, la eliminaci�n fall&oacute;. Por favor, regrese y vuelva a intentarlo.";
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
				<strong>�Bien hecho!</strong>
				<?php
					foreach ($messages as $message) {
							echo $message;
						}
					?>
		</div>
<?php
	}
ob_end_flush();
?>