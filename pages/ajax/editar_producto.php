<?php

    if (empty($_POST['edit_id']) || empty($_POST['edit_nombre_producto']) || empty($_POST['edit_nombre_corto_producto']) || 
        empty($_POST['edit_precio']) || empty($_POST['edit_estado']))
    {
        if (empty($_POST['edit_id']))
            $errors[] = "ID está vacío.";
        if (empty($_POST['edit_nombre_producto']))
            $errors[] = "Ingrese nombre del producto.";
        if (empty($_POST['edit_nombre_corto_producto']))
            $errors[] = "Ingrese nombre corto del producto.";
        if (empty($_POST['edit_precio']))
            $errors[] = "Ingrese precio del producto.";
        if (empty($_POST['edit_estado']))
            $errors[] = "Ingresa estado del producto.";
                        
    }	
    elseif (!empty($_POST['edit_id']) && !empty($_POST['edit_nombre_producto']) && !empty($_POST['edit_nombre_corto_producto']) 
        && !empty($_POST['edit_precio']) && !empty($_POST['edit_estado']))
    {
        require_once ("../php_util/conexion.php");//Contiene funcion que conecta a la base de datos
        $conexion = mConectar();
        
        // escaping, additionally removing everything that could be (html/javascript-) code
        //$cli_code = mysqli_real_escape_string($conexion,(strip_tags($_POST["edit_code"],ENT_QUOTES)));
        $id=intval($_POST['edit_id']);
        $pro_nombre_producto = mysqli_real_escape_string($conexion,(strip_tags($_POST["edit_nombre_producto"],ENT_QUOTES)));
        $pro_nombre_corto_producto = mysqli_real_escape_string($conexion,(strip_tags($_POST["edit_nombre_corto_producto"],ENT_QUOTES)));
        $pro_precio = doubleval($_POST["edit_precio"]);                
        $pro_estado = mysqli_real_escape_string($conexion,(strip_tags($_POST["edit_estado"],ENT_QUOTES)));
        $cli_fecha_modificacion=date("Y-m-d H:i:s");
        $cli_usuario_modificacion="fcontreras";
        
        $revisar = getimagesize($_FILES["idFileProducto_edit"]["tmp_name"]);
        // addslashes para escapar cadena
        $updateImagen=false;
        if($revisar != false && $revisar != null){
            $imgNombre=addslashes($_FILES['idFileProducto_edit']['name']);
            $imgContenido = addslashes(file_get_contents($_FILES['idFileProducto_edit']['tmp_name']));
            $imgType=addslashes($_FILES['idFileProducto_edit']['type']);
            $updateImagen=true;
        }       
        
        // UPDATE data into database
        if ($updateImagen)            
            $sql = " UPDATE productos SET nombre_producto = '".$pro_nombre_producto."',nombre_corto_producto = '".$pro_nombre_corto_producto."',imagen = '".$imgContenido."', mime = '".$imgType."', precio = ".$pro_precio.", estado = '".$pro_estado."', fecha_modificacion = '".$cli_fecha_modificacion."', usuario_modificacion = '".$cli_usuario_modificacion."'
                WHERE id_producto='".$id."' ";
        else 
            $sql = " UPDATE productos SET nombre_producto = '".$pro_nombre_producto."',nombre_corto_producto = '".$pro_nombre_corto_producto."',precio = ".$pro_precio.", estado = '".$pro_estado."', fecha_modificacion = '".$cli_fecha_modificacion."', usuario_modificacion = '".$cli_usuario_modificacion."'
                WHERE id_producto='".$id."' ";
        
        $query = $conexion->query($sql);       
        // if product has been added successfully
        if ($query) {
            $messages[] = "El producto ha sido actualizado con &eacute;xito.";
        } else {
            $errors[] = "Lo sentimos, la actualizaci&oacute;n fall&oacute;. Por favor, regrese y vuelva a intentarlo.";
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