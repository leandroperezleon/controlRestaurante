<?php
ob_start();
session_start();
$idusuario=$_SESSION['idusuario'];

/* Connect To Database*/
require_once ("../php_util/conexion.php");
$conexion = mConectar();

$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
if($action == 'ajax')
{
    //pagination variables
    include 'pagination.php'; //include pagination file
    
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
    $per_page = intval($_REQUEST['per_page']); //cuantos registros mostrar por pantalla
    $adjacents  = 4;
    $offset = ($page - 1) * $per_page;
    $fechaHoy=date('Y-m-d');   
    $fechaIngreso=date("Y-m-d H:i:s");
    $usuarioIngreso="fcontreras";
    
    if(isset($_REQUEST['fechaConsulta']))
    {   $fechaHoy = date($_REQUEST['fechaConsulta']); 
        $fechaIngreso = date($_REQUEST['fechaConsulta']); 
    }
    
    // verifica si existen registros en la tabla para la fecha hoy
    $sentencia = "  select
                    count(*) numrows
                    from pedido ped inner join clientes cli on ped.id_cliente = cli.id_cliente
                    left join productos pro on ped.id_producto = pro.id_producto
                    where cli.id_empresa = ". $_SESSION['idempresa'] ."
                    and cli.estado='1'
                    and date(ped.fecha_ingreso) = '$fechaHoy' ";   
    $count_query = $conexion->query($sentencia)or die("Problemas en el select:".$conexion->error);
    $row= $count_query->fetch_array();
    if ($row !=null)
    {
        $numrows = $row['numrows'];
        if($numrows ==0)
        {
            /* insertar registro por cada cliente del dia */
            $result = $conexion->query(" select cli.id_cliente,
                                        per.nombres,
                                        per.apellidos,
                                        per.identificacion,
                                        cli.nombre_corto,
                                        cli.estado,
                                        cli.comentarios,
                                        cli.id_persona
                                        from clientes cli
                                        inner join personas per on cli.id_persona = per.id_persona
                                        where cli.id_empresa= ".$_SESSION['idempresa']."
                                            and cli.estado = '1'
                                            and per.estado= '1'  ");
            while($row = mysqli_fetch_array($result))
            {
                $id_cliente=$row['id_cliente'];
                $queryInsert = $conexion->query("INSERT INTO pedido(id_usuario,id_cliente,id_producto,cantidad,fecha_ingreso,usuario_ingreso)
                                                VALUES ('$idusuario','$id_cliente' ,0,0,'$fechaIngreso','$usuarioIngreso')");
                if (!$queryInsert)
                {
                    echo "Error en insertar pedidos totales";
                    // ob_end_flush();
                    exit;
                }
            } 
        }
    }    
        
    //cuenta el numero total de filas de la tabla*/ 
    $sentencia = "  select
                    count(*) numrows
                    from pedido ped inner join clientes cli on ped.id_cliente = cli.id_cliente
                    left join productos pro on ped.id_producto = pro.id_producto
                    where cli.id_empresa = ". $_SESSION['idempresa'] ."
                    and cli.estado='1'
                    and date(ped.fecha_ingreso) = '$fechaHoy' ";
    $count_query = $conexion->query($sentencia)or die("Problemas en el select:".$conexion->error);
    $row= $count_query->fetch_array();
    if ($row !=null)
    {   $numrows = $row['numrows'];
    }
    else 
    {   echo mysqli_error($conexion);
    }    
    $total_pages = ceil($numrows/$per_page);
    
    //query obtener data
    $sentencia = "  select
                    ped.id_pedido as id_pedido,
                    usu.id_usuario as id_usuario,
                    usu.username as username,
                    cli.id_cliente as id_cliente,
                    cli.nombre_corto as nombre_corto,
                    pro.id_producto as id_producto,
                    pro.nombre_corto_producto as nombre_corto_producto,
                    ped.cantidad as cantidad,
                    date(ped.fecha_ingreso) fecha_ingreso
                    from pedido ped inner join usuarios usu on ped.id_usuario = usu.id_usuario
                    inner join clientes cli on ped.id_cliente = cli.id_cliente
                    left join productos pro on ped.id_producto = pro.id_producto
                    where usu.id_usuario = $idusuario
                    and cli.estado='1'
                    and cli.id_empresa = ". $_SESSION['idempresa'] ."
                    and date(ped.fecha_ingreso) = '$fechaHoy' order by id_cliente ";    
    $query = $conexion->query($sentencia. " LIMIT $offset,$per_page");
        
    //bucle para obtener la data
    if ($numrows>0){
?>
		<script src="../../js/script_edit_pedidos.js"></script>
		<form name="edit_pedido" id="edit_pedido">
    		<div class="table-responsive">        			
    			<table class="table table-striped table-hover">
    				<thead>
    					<tr>
    						<th hidden="hidden" class='text-left'>C&oacute;digo Pedido</th>
        					<th class='text-left'>Nombre Cliente</th>
        					<th class='text-left'>Nombre Producto</th>
        					<th class='text-left'>Cantidad</th>        					
    					</tr>
    				</thead>
    				<tbody>	
    					<?php 
    						$finales=0;
    						while($row = mysqli_fetch_array($query))
    						{	
    						    $id_pedido=$row['id_pedido'];
    						    $id_usuario=$row['id_usuario'];
    						    $username=$row['username'];
    						    $id_cliente=$row['id_cliente'];
    							$nombre_corto=$row['nombre_corto'];
    							$id_producto=$row['id_producto'];
    							$nombre_corto_producto=$row['nombre_corto_producto'];
    							$cantidad=$row['cantidad'];
    							$fecha_ingreso=$row['fecha_ingreso'];
    							$finales++;
    					?>	
    						<tr class="<?php echo $text_class;?>">
    							<td hidden class='text-left'><input name="idped[]" value="<?php echo $id_pedido;?>"/></td>                            
    							<td hidden="hidden" class='text-left'><input name="idped2[<?php echo $id_pedido;?>]" value="<?php echo $id_pedido;?>" readonly="readonly"/></td>
                                <td class='text-left'><input name="nomcli[<?php echo $id_pedido;?>]" value="<?php echo $nombre_corto;?>" readonly="readonly"/></td>
                                <td class='text-left'>
                                    <select id="mi_producto[<?php echo $id_pedido;?>]" name="mi_producto[<?php echo $id_pedido;?>]" onChange="mCambiarSeleccion(<?php echo $id_pedido;?>)">
                                        <option value="0">Seleccione:</option>
                                        <?php
                                        // obtiene lista de productos
                                        $queryProducto = $conexion->query("  select * from productos pro where pro.estado='1' order by id_producto "); 
                                        while ($valores = mysqli_fetch_array($queryProducto)) 
                                        {
                                            $id_producto_lista=$valores['id_producto'];
                                            $nombre_corto_producto_lista=$valores['nombre_corto_producto'];
                                            if($id_producto == $id_producto_lista)
                                            {
                                        ?>    
                                            	<option value="<?php echo $id_producto_lista;?>" selected="selected"><?php echo $nombre_corto_producto_lista; ?></option>
                                        <?php
                                            }
                                            else
                                            {
                                        ?>
                                            	<option value="<?php echo $id_producto_lista;?>" ><?php echo $nombre_corto_producto_lista; ?></option>
                                        <?php                                 
                                            }
                                        }                                        
                                        ?>
                                    </select>
                                </td>
                                <td class='text-left'><input type="text" id="cant[<?php echo $id_pedido;?>]" name="cant[<?php echo $id_pedido;?>]" value="<?php echo $cantidad;?>" /></td>
                                <td hidden class='text-left'><input type="text" id="nomProSeleccionado[<?php echo $id_pedido;?>]" name="nomProSeleccionado[<?php echo $id_pedido;?>]" value=""/></td>
								<td hidden class='text-left'><input type="date" id="fechaIngreso[<?php echo $id_pedido;?>]" name="fechaIngreso[<?php echo $id_pedido;?>]" value="<?php echo $fecha_ingreso;?>"/></td>                                    							
    						</tr>
    					<?php }
    					       mDesconectar($conexion);
    					   ?>
    						<tr>
    							<td colspan='6'> 
    								<?php 
    									$inicios=$offset+1;
    									$finales+=$inicios -1;
    									echo "Mostrando $inicios al $finales de $numrows registros";
    									echo paginate( $page, $total_pages, $adjacents);
    								?>
    							</td>
    						</tr>
    				</tbody>			
    			</table>        		
    		</div>
			<input type="submit" value="Actualizar Registros" class="btn btn-info col-md-offset-9" />				
		</form>	
	<?php	
	}	
}
ob_end_flush();
?>