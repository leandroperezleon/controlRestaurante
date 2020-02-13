<?php
ob_start();
session_start();

/* Connect To Database*/
require_once ("../php_util/conexion.php");
$conexion = mConectar();

$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
if($action == 'ajax')
{
    $fechaDesde = date($_REQUEST['fechaDesde']);
    $fechaHasta = date($_REQUEST['fechaHasta']);
           
    //pagination variables
    include 'pagination.php'; //include pagination file
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
    $per_page = intval($_REQUEST['per_page']); //cuantos registros mostrar por pantalla
    $adjacents  = 4;
    $offset = ($page - 1) * $per_page;
    
    //cuenta el numero total de filas de la tabla*/ 
    $sentencia = "  select
                    count(*) numrows
                    from
                    (
                    select per.nombres,
                    per.apellidos,
                    (select pro.nombre_corto_producto from productos pro where id_producto =1) producto1,
                    sum(if(ped.id_producto=1, ped.cantidad,0)) as cantidadTotal1,
                    sum(if(ped.id_producto=1, ped.cantidad*pro.precio,0)) as precioTotal1,
                    (select pro.nombre_corto_producto from productos pro where id_producto =2) producto2,
                    sum(if(ped.id_producto=2, ped.cantidad,0)) as cantidadTotal2,
                    sum(if(ped.id_producto=2, ped.cantidad*pro.precio,0)) as precioTotal2,
                    (select pro.nombre_corto_producto from productos pro where id_producto =3) producto3,
                    sum(if(ped.id_producto=3, ped.cantidad,0)) as cantidadTotal3,
                    sum(if(ped.id_producto=3, ped.cantidad*pro.precio,0)) as precioTotal3,
                    (select pro.nombre_corto_producto from productos pro where id_producto =4) producto4,
                    sum(if(ped.id_producto=4, ped.cantidad,0)) as cantidadTotal4,
                    sum(if(ped.id_producto=4, ped.cantidad*pro.precio,0)) as precioTotal4
                    from pedido ped
                    inner join productos pro on ped.id_producto = pro.id_producto
                    inner join clientes cli on ped.id_cliente = cli.id_cliente
                    inner join personas per on per.id_persona = cli.id_persona
                    where ped.id_usuario= ".$_SESSION['idusuario']."
                    and date(ped.fecha_ingreso) >= '$fechaDesde'
                    and date(ped.fecha_ingreso) <= '$fechaHasta'
                    group by per.nombres,
                    		 per.apellidos
                    order by per.identificacion,  ped.id_producto
                    )x ";
    $count_query = $conexion->query($sentencia)or die("Problemas en el select:".$conexion->error);;
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
                    x.nombres,
                    x.apellidos,
                    x.producto1, 
                    x.cantidadTotal1, 
                    x.precioTotal1,
                    x.producto2, 
                    x.cantidadTotal2, 
                    x.precioTotal2,
                    x.producto3, 
                    x.cantidadTotal3, 
                    x.precioTotal3,
                    x.producto4, 
                    x.cantidadTotal4, 
                    x.precioTotal4,
                    (x.precioTotal1+x.precioTotal2+x.precioTotal3) montoTotal
                    from
                    (
                    select per.nombres,
                    per.apellidos,
                    (select pro.nombre_corto_producto from productos pro where id_producto =1) producto1, 
                    sum(if(ped.id_producto=1, ped.cantidad,0)) as cantidadTotal1, 
                    sum(if(ped.id_producto=1, ped.cantidad*pro.precio,0)) as precioTotal1,
                    (select pro.nombre_corto_producto from productos pro where id_producto =2) producto2, 
                    sum(if(ped.id_producto=2, ped.cantidad,0)) as cantidadTotal2, 
                    sum(if(ped.id_producto=2, ped.cantidad*pro.precio,0)) as precioTotal2,
                    (select pro.nombre_corto_producto from productos pro where id_producto =3) producto3, 
                    sum(if(ped.id_producto=3, ped.cantidad,0)) as cantidadTotal3, 
                    sum(if(ped.id_producto=3, ped.cantidad*pro.precio,0)) as precioTotal3,
                    (select pro.nombre_corto_producto from productos pro where id_producto =4) producto4,
                    sum(if(ped.id_producto=4, ped.cantidad,0)) as cantidadTotal4,
                    sum(if(ped.id_producto=4, ped.cantidad*pro.precio,0)) as precioTotal4
                    from pedido ped  
                    inner join productos pro on ped.id_producto = pro.id_producto
                    inner join clientes cli on ped.id_cliente = cli.id_cliente
                    inner join personas per on per.id_persona = cli.id_persona
                    where ped.id_usuario= ".$_SESSION['idusuario']."
                    and date(ped.fecha_ingreso) >= '$fechaDesde'
                    and date(ped.fecha_ingreso) <= '$fechaHasta'
                    group by per.nombres,
                    		 per.apellidos        
                    order by per.identificacion,  ped.id_producto
                    )x ";
    $query = $conexion->query($sentencia. " LIMIT $offset,$per_page");
    $queryTemp = $conexion->query($sentencia);
    mDesconectar($conexion);
    
    $rowTemp = mysqli_fetch_array($queryTemp);
    $prov1=$rowTemp['producto1'];
    $prov2=$rowTemp['producto2'];
    $prov3=$rowTemp['producto3'];
    $prov4=$rowTemp['producto4'];
    
    //bucle para obtener la data
    if ($numrows>0){
?>
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th class='text-left'>Nombres</th>						
						<th class='text-left'>Apellidos</th>
						<th class='text-center' colspan="2"><p><?php echo $prov1;?></p>Cantidad  - Monto</th>
						<th class='text-center' colspan="2"><p><?php echo $prov2;?></p>Cantidad  - Monto</th>
						<th class='text-center' colspan="2"><p><?php echo $prov3;?></p>Cantidad  - Monto</th>
						<th class='text-center' colspan="2"><p><?php echo $prov4;?></p>Cantidad  - Monto</th>
						<th class='text-left'>Monto total</th>
					</tr>
				</thead>
				<tbody>	
					<?php 
						$finales=0;
						while($row = mysqli_fetch_array($query))
						{	
							$nombres=$row['nombres'];
							$apellidos=$row['apellidos'];							
							$cantidadTotal_1=$row['cantidadTotal1'];
							$precioTotal_1=$row['precioTotal1'];								
							$cantidadTotal_2=$row['cantidadTotal2'];
							$precioTotal_2=$row['precioTotal2'];							
							$cantidadTotal_3=$row['cantidadTotal3'];
							$precioTotal_3=$row['precioTotal3'];							
							$cantidadTotal_4=$row['cantidadTotal4'];
							$precioTotal_4=$row['precioTotal4'];
							$montoTotal=$row['montoTotal'];
							$finales++;
					?>	
						<tr class="<?php echo $text_class;?>">
							<td class='text-left'><?php echo $nombres;?></td>
							<td class='text-left'><?php echo $apellidos;?></td>							
							<td class='text-left'><?php echo $cantidadTotal_1;?></td>							
							<td class='text-left'><?php echo $precioTotal_1;?></td>								
							<td class='text-left'><?php echo $cantidadTotal_2;?></td>							
							<td class='text-left'><?php echo $precioTotal_2;?></td>							
							<td class='text-left'><?php echo $cantidadTotal_3;?></td>							
							<td class='text-left'><?php echo $precioTotal_3;?></td>							
							<td class='text-left'><?php echo $cantidadTotal_4;?></td>							
							<td class='text-left'><?php echo $precioTotal_4;?></td>						
							<td class='text-left'><?php echo $montoTotal;?></td>					
						</tr>
					<?php }?>
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
	<?php	
	}	
}
ob_end_flush();
?>