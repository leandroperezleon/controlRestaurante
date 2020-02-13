<?php
    ob_start();
    if (empty($_POST['nombres']) || empty($_POST['apellidos']) || empty($_POST['identificacion']) || empty($_POST['nombreCorto']))
    {
        if (empty($_POST['nombres']))
            $errors[] = "Ingresa nombre del cliente.";
        if (empty($_POST['apellidos']))
            $errors[] = "Ingresa apellido del cliente.";
        if (empty($_POST['identificacion']))
           $errors[] = "Ingrese identificacion del cliente.";
        if (empty($_POST['nombreCorto']))
           $errors[] = "Ingresa nombre corto del cliente.";
        
    }	
    elseif (!empty($_POST['nombres']) && !empty($_POST['apellidos']) && !empty($_POST['identificacion']) && !empty($_POST['nombreCorto']))
	{
    	require_once ("../php_util/conexion.php");//Contiene funcion que conecta a la base de datos
    	$conexion = mConectar();
    	
    	// escaping, additionally removing everything that could be (html/javascript-) code
    	$cli_nombres = mysqli_real_escape_string($conexion,(strip_tags($_POST["nombres"],ENT_QUOTES)));
    	$cli_apellidos = mysqli_real_escape_string($conexion,(strip_tags($_POST["apellidos"],ENT_QUOTES)));
    	$cli_identificacion = mysqli_real_escape_string($conexion,(strip_tags($_POST["identificacion"],ENT_QUOTES)));
    	$cli_nombreCorto = mysqli_real_escape_string($conexion,(strip_tags($_POST["nombreCorto"],ENT_QUOTES)));
    	$cli_comentarios = mysqli_real_escape_string($conexion,(strip_tags($_POST["comentarios"],ENT_QUOTES))); 
    	$cli_estado=1;
    	$cli_fechaIngreso=date("Y-m-d H:i:s");
    	$cli_usuarioIngreso="fcontreras";
    	
    	session_start();
    	$idempresa=$_SESSION['idempresa'];
    	
    	// verifica que no este registrado un cliente por numero identificacion
    	$id_query   = $conexion->query("SELECT id_persona FROM personas where identificacion = '$cli_identificacion' ")
    	                                  or die("Problemas en el select:".$conexion->error);
    	$row= $id_query->fetch_array();
    	if ($row !=null)
    	{
    	   //$errors[] = "Ya existe cliente con numero identificacion ingresado...";
    	   $numrows=  $row['id_persona'];
    	}   	
    	else
    	{
    	    // REGISTER data into database
    	    $sql = "INSERT INTO personas
                ( id_empresa, nombres, apellidos, identificacion, email,
                  telefono,   celular, estado,    fecha_ingreso,  usuario_ingreso)
                VALUES
                ( $idempresa, '$cli_nombres','$cli_apellidos', '$cli_identificacion', '',
                  '',  '', '$cli_estado', '$cli_fechaIngreso','$cli_usuarioIngreso') ";
    	    
    	    $query = $conexion->query($sql);
    	    if ($query)
    	    {
    	        $id_query   = $conexion->query("SELECT max(id_persona) AS max_id FROM personas where identificacion = '$cli_identificacion' ")
    	        or die("Problemas en el select:".$conexion->error);
    	        $row= $id_query->fetch_array();
    	        if ($row !=null)
    	           $numrows = $row['max_id'];
    	        else
    	            $numrows =1; 	            
    	    } 
    	    else
    	        $errors[] = "Lo sentimos, el registro fall&oacute al insertar persona;. Por favor, regrese y vuelva a intentarlo.";
    	}
    	
    	
    	if (!isset($errors))
    	{
    	    // inserta cliente
    	    $sql = " INSERT INTO clientes
                (   id_persona,    id_empresa, nombre_corto, comentarios, estado,
                    fecha_ingreso, usuario_ingreso
                 )
                 VALUES
                 (  $numrows,            $idempresa, '$cli_nombreCorto', '$cli_comentarios', '$cli_estado',
                    '$cli_fechaIngreso','$cli_usuarioIngreso'
                  ); ";
    	    $query = $conexion->query($sql);
    	    // if cliente usuario has been added successfully
    	    if ($query)
    	        $messages[] = "El cliente ha sido guardado con &eacute;xito.";
    	    else
    	        $errors[] = "Lo sentimos, el registro fall&oacute al insertar cliente;. Por favor, regrese y vuelva a intentarlo.";
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
ob_end_flush();
?>