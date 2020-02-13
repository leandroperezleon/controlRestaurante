<?php
    ob_start();
    session_start();
    $idusuario=$_SESSION['idusuario'];
    $fechaHoy=date('Y-m-d');
    $textoMensaje="";
        
    require_once ("../php_util/conexion.php");//Contiene funcion que conecta a la base de datos
    $conexion = mConectar();
        
    foreach ($_POST['idped'] as $ids)
    {
        $editId=mysqli_real_escape_string($conexion, $_POST['idped2'][$ids]);
        //$editIdPro=mysqli_real_escape_string($conexion, $_POST['idproducto'][$ids]);
        //$editNomPro=mysqli_real_escape_string($conexion, $_POST['nomproducto'][$ids]);
        $editNomCli=mysqli_real_escape_string($conexion, $_POST['nomcli'][$ids]);
        $fechaIngreso=mysqli_real_escape_string($conexion, $_POST['fechaIngreso'][$ids]);
        // lista
        $ped_productoLista=mysqli_real_escape_string($conexion, $_POST['mi_producto'][$ids]);
        $ped_IdProLista=$ped_productoLista;
        $ped_NomProSeleccionado=mysqli_real_escape_string($conexion, $_POST['nomProSeleccionado'][$ids]);
        
        $ped_cant=intval($_POST['cant'][$ids]);
        $ped_fechaModificacion=date("Y-m-d H:i:s");
        $ped_usuarioModificacion="fcontreras";        
        $actualizar=$conexion->query("UPDATE pedido SET id_producto='$ped_IdProLista', cantidad='$ped_cant', fecha_modificacion='$ped_fechaModificacion', usuario_modificacion='$ped_usuarioModificacion'
                                         WHERE id_pedido='$ids'"); 
    }
        
    if($actualizar)
    	$messages[] = "El producto ha sido actualizado con &eacute;xito.";
    else
        $errors[] = "Lo sentimos, la actualizaci&oacute;n fall&oacute;. Por favor, regrese y vuelva a intentarlo.";
            
    mDesconectar($conexion);

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
					/* solo muestra resumen y envio por whatsapp en pedidos del dia hoy.... */	
					if($fechaIngreso != $fechaHoy)
					    exit();
				?>
		</div>		
		
		
		<div class="row" >
			<div class="col-sm-4 pull-left ">
        		<div class="table-responsive">        			
        			<table class="table table-striped table-hover">
        				<thead>
        					<tr>
        						<th class='text-left'>Producto</th>
            					<th class='text-left'>Cantidad</th>
            					<th class='text-left'>Monto</th>        					
        					</tr>
        				</thead>
        				<tbody>	
        					<?php 
        					    $conexion = mConectar();
        						$sentencia = "  select pro.nombre_corto_producto as nombre_corto_producto, 
                                                sum(ped.cantidad) as cantidadTotal, 
                                                sum(ped.cantidad*pro.precio) as precioTotal
                                                from pedido ped  
                                                inner join productos pro on ped.id_producto = pro.id_producto
                                                where ped.id_usuario= $idusuario
                                                and date(ped.fecha_ingreso) = '$fechaHoy'
                                                group by ped.id_producto ";                    	
        						$query = $conexion->query($sentencia);
        						$totalDia=0;
        						while($row = mysqli_fetch_array($query))
        						{	
        						    $nombre_corto_producto=$row['nombre_corto_producto'];
        						    $cantidadTotal=$row['cantidadTotal'];
        						    $precioTotal=$row['precioTotal'];  						    
        						    $totalDia+=$precioTotal;    
        						    
        						    // armar mensaje para envio whats
        						    if(ENVIARWHATSAPP=="S")
        						      if($cantidadTotal!=0)
        						          $textoMensaje=$textoMensaje."Producto: ".$nombre_corto_producto."%0A"." Cantidad: ".$cantidadTotal."%0A"."==="."%0A";
        						            						    
        						    
        					?>	
        						<tr class="<?php echo $text_class;?>">
        							<td class='text-left'><?php echo $nombre_corto_producto;?></td>				     
        							<td class='text-left'><?php echo $cantidadTotal;?></td>
                                    <td class='text-left'><?php echo $precioTotal;?></td>  							
        						</tr>        						
        					<?php }        					   
        					   mDesconectar($conexion);        					   
        					   ?>        					   
        				</tbody>			
        			</table>        		
            	</div>
            </div>	
        </div> 
        
        <div class="alert alert-warning" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<b>Total monto del d&iacute;a: </b><?php echo $totalDia;?>
		</div>	
		
		<?php 
		if(ENVIARWHATSAPP=="S" && $textoMensaje!='')
    	{
		?>
			<div id="botonwhatsapp">
         		<a  href="https://wa.me/?text=<?php echo $textoMensaje;?>">Enviar por Whatsapp</a> 
    	   	</div>
    	<?php 
    	}
		?>	
				
<?php
	}
ob_end_flush();
?>