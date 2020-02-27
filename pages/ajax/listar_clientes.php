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
    $sWhere=" per.nombres LIKE '%".$query."%'";
    $sWhere.=" order by per.nombres ";
           
    //pagination variables
    include 'pagination.php'; //include pagination file
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
    $per_page = intval($_REQUEST['per_page']); //cuantos registros mostrar por pantalla
    $adjacents  = 4;
    $offset = ($page - 1) * $per_page;
    
    //cuenta el numero total de filas de la tabla*/ 
    $sentencia = "  select count(*) numrows 
                    from clientes cli
                    inner join personas per on cli.id_persona = per.id_persona
                    where cli.id_empresa= ".$_SESSION['idusuario']."
                    and cli.estado = '1'
                    and per.estado= '1' and ".$sWhere;    
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
    $sentencia = "  select cli.id_cliente,
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
                    and per.estado= '1' and ".$sWhere;   
    $query = $conexion->query($sentencia. " LIMIT $offset,$per_page");
    mDesconectar($conexion);
    
    //bucle para obtener la data
    if ($numrows>0){
?>
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th hidden="hidden" class='text-left'>C&oacute;digo</th>
						<th class='text-left'>Nombres</th>
						<th class='text-left'>Apellidos</th>
						<th class='text-left'>Identificaci&oacute;n</th>
						<th class='text-left'>Nombre corto</th>
						<th></th>
					</tr>
				</thead>
				<tbody>	
					<?php 
						$finales=0;
						while($row = mysqli_fetch_array($query))
						{	
							$id_cliente=$row['id_cliente'];
							$nombres=$row['nombres'];
							$apellidos=$row['apellidos'];
							$identificacion=$row['identificacion'];
							$nombre_corto=$row['nombre_corto'];
							$estado=$row['estado'];						
							$id_persona=$row['id_persona'];						
							$finales++;
					?>	
						<tr class="<?php echo $text_class;?>">
							<td hidden="hidden" class='text-left'><?php echo $id_cliente;?></td>
							<td class='text-left'><?php echo $nombres;?></td>
							<td class='text-left'><?php echo $apellidos;?></td>
							<td class='text-left'><?php echo $identificacion;?></td>
							<td class='text-left'><?php echo $nombre_corto;?></td>							
							<td>
								<a href="#" data-target="#editClienteModal" class="edit" data-toggle="modal" data-nombres="<?php echo $nombres;?>" data-apellidos="<?php echo $apellidos;?>" data-identificacion="<?php echo $identificacion;?>" data-nombre_corto="<?php echo $nombre_corto;?>" data-estado="<?php echo $estado;?>" data-code="<?php echo $id_cliente;?>" data-id="<?php echo $id_cliente;?>"><i class="material-icons" data-toggle="tooltip" title="Editar" >&#xE254;</i></a>
								<a href="#deleteClienteModal" class="delete" data-toggle="modal" data-id="<?php echo $id_cliente;?>"><i class="material-icons" data-toggle="tooltip" title="Eliminar">&#xE872;</i></a>
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