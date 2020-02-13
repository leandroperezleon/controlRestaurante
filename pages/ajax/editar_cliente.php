<?php

    if (empty($_POST['edit_id']) || empty($_POST['edit_nombres']) || empty($_POST['edit_apellidos']) || 
        empty($_POST['edit_identificacion']) || empty($_POST['edit_nombre_corto']) || empty($_POST['edit_estado']))
    {
        if (empty($_POST['edit_id']))
            $errors[] = "ID está vacío.";
        if (empty($_POST['edit_nombres']))
            $errors[] = "Ingresa nombre del cliente.";
        if (empty($_POST['edit_apellidos']))
            $errors[] = "Ingresa apellido del cliente.";
        if (empty($_POST['edit_identificacion']))
            $errors[] = "Ingrese identificacion del cliente.";
        if (empty($_POST['edit_nombre_corto']))
            $errors[] = "Ingresa nombre corto del cliente.";
        if (empty($_POST['edit_estado']))
            $errors[] = "Ingresa estado del cliente.";
                        
    }	
    elseif (!empty($_POST['edit_id']) && !empty($_POST['edit_nombres']) && !empty($_POST['edit_apellidos']) && !empty($_POST['edit_identificacion']) 
        && !empty($_POST['edit_nombre_corto']) && !empty($_POST['edit_estado']))
    {
        require_once ("../php_util/conexion.php");//Contiene funcion que conecta a la base de datos
        $conexion = mConectar();
        
        // escaping, additionally removing everything that could be (html/javascript-) code
        //$cli_code = mysqli_real_escape_string($conexion,(strip_tags($_POST["edit_code"],ENT_QUOTES)));
        $id=intval($_POST['edit_id']);
        $cli_nombres = mysqli_real_escape_string($conexion,(strip_tags($_POST["edit_nombres"],ENT_QUOTES)));
        $cli_apellidos = mysqli_real_escape_string($conexion,(strip_tags($_POST["edit_apellidos"],ENT_QUOTES)));
        $cli_identificacion = mysqli_real_escape_string($conexion,(strip_tags($_POST["edit_identificacion"],ENT_QUOTES)));
        $cli_nombre_corto = mysqli_real_escape_string($conexion,(strip_tags($_POST["edit_nombre_corto"],ENT_QUOTES)));        
        $cli_estado = mysqli_real_escape_string($conexion,(strip_tags($_POST["edit_estado"],ENT_QUOTES)));
        //$cli_comentarios = mysqli_real_escape_string($conexion,(strip_tags($_POST["edit_comentarios"],ENT_QUOTES)));
                   
        // UPDATE data into database
        $sql = " UPDATE personas 
                SET nombres = '".$cli_nombres."',
                apellidos = '".$cli_apellidos."',
                identificacion = '".$cli_identificacion."',                
                estado = '".$cli_estado."'
                WHERE id_persona = (select id_persona from clientes where id_cliente = id_cliente='".$id."' ) ";         
        $query = $conexion->query($sql);
        
        if ($query) 
        {
            $sql = " UPDATE clientes
                SET nombre_corto = '".$cli_nombre_corto."',
                estado = '".$cli_estado."'
                WHERE id_cliente='".$id."' ";
            $query = $conexion->query($sql);
            
            if ($query)
            {
                $messages[] = "El cliente ha sido actualizado con &eacute;xito.";
            }
            else
            {
                $errors[] = "Lo sentimos, la actualizaci&oacute;n fall&oacute al actualizar cliente;. Por favor, regrese y vuelva a intentarlo.";
            }
        }
        else 
        {
            $errors[] = "Lo sentimos, la actualizaci&oacute;n fall&oacute; al actualizar persona. Por favor, regrese y vuelva a intentarlo.";
        }
        // desconectar
        mDesconectar($conexion);
        
    } else
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