<?php
ob_start();
session_start();

/* Connect To Database*/
require_once ("../php_util/conexion.php");
$conexion = mConectar();

$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
if($action == 'ajax')
{
    $query = mysqli_real_escape_string($conexion,(strip_tags($_REQUEST['query'], ENT_QUOTES)));
    $sWhere=" nombre_producto LIKE '%".$query."%'";
    $sWhere.=" order by nombre_producto";
           
    //pagination variables
    include 'pagination.php'; //include pagination file
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
    $per_page = intval($_REQUEST['per_page']); //cuantos registros mostrar por pantalla
    $adjacents  = 4;
    $offset = ($page - 1) * $per_page;
    
    //cuenta el numero total de filas de la tabla*/ 
    $sentencia = " select count(*) numrows from productos pro where pro.estado = '1' and ".$sWhere;    
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
    $sentencia = " select pro.* from productos pro where pro.estado = '1' and ".$sWhere;
    $query = $conexion->query($sentencia. " LIMIT $offset,$per_page");
    mDesconectar($conexion);
    
    //bucle para obtener la data
    if ($numrows>0){
?>
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th class='text-left'>C&oacute;digo</th>
						<th class='text-left'>Nombre producto</th>
						<th class='text-left'>Nombre Corto producto</th>
						<th class='text-left'>Precio</th>
						<th></th>
					</tr>
				</thead>
				<tbody>	
					<?php 
						$finales=0;
						while($row = mysqli_fetch_array($query))
						{	
						    $id_producto=$row['id_producto'];
							$nombre_producto=$row['nombre_producto'];
							$nombre_corto_producto=$row['nombre_corto_producto'];
							$precio=$row['precio'];
							$estado=$row['estado'];						
							$finales++;
					?>	
						<tr class="<?php echo $text_class;?>">
							<td class='text-left'><?php echo $id_producto;?></td>
							<td class='text-left'><?php echo $nombre_producto;?></td>
							<td class='text-left'><?php echo $nombre_corto_producto;?></td>
							<td class='text-left'><?php echo $precio;?></td>														
							<td>
								<a href="#" data-target="#editProductoModal" class="edit" data-toggle="modal" data-nombre_producto="<?php echo $nombre_producto;?>" data-nombre_corto_producto="<?php echo $nombre_corto_producto;?>" data-precio="<?php echo $precio;?>"  data-estado="<?php echo $estado;?>" data-code="<?php echo $id_producto;?>" data-id="<?php echo $id_producto;?>"><i class="material-icons" data-toggle="tooltip" title="Editar" >&#xE254;</i></a>
								<a href="#deleteProductoModal" class="delete" data-toggle="modal" data-id="<?php echo $id_producto;?>"><i class="material-icons" data-toggle="tooltip" title="Eliminar">&#xE872;</i></a>
                    		</td>
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