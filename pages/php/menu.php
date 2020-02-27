<!-- Sidebar  -->
<nav id="sidebar" >
    <div class="sidebar-header">
        <h3>Control Restaurante</h3>
        <strong>CR</strong>
    </div>
    <ul class="list-unstyled components">            
        <?php     	 
            if(!isset($_SESSION['$vectormenu']))
            {
                include '../php_util/conexion.php';  	           	     
                $conexion = mConectar();
                if ($conexion==null || $conexion->connect_error ) {
                                die("La conexion fallo: " . $conexion->connect_error);
                }
                     	     
                $result = $conexion->query(" select mn.nombre_pagina,                                  	      
                                          mn.logo,
                                          mn.etiqueta,
                                          mn.contenido
                                  	      from menu mn
                                  	      inner join menu_x_rol mnr on mn.id_menu = mnr.id_menu
                                  	      where id_empresa= ".$_SESSION['idempresa']."
                                  	      and mnr.id_rol =  ".$_SESSION['idrol']."
                                  	      and mn.estado = '1'
                                  	      order by orden") or die("Problemas en el select:".$conexion->error);
                while($row = mysqli_fetch_array($result))
                {
                    $vectormenu[] = array('nombre_pagina'=> $row['nombre_pagina'],
                                          'logo'=> $row['logo'],
                                          'etiqueta'=> $row['etiqueta']);
                                     
        ?>                    
                    <li>
                        <a href="<?php echo $row['nombre_pagina']?>">
                    		<i class="<?php echo $row['logo']?>"></i>
                    		<?php echo $row['etiqueta']?>
                        </a>
                    </li> 
        <?php        
                }   
                $_SESSION['$vectormenu'] =$vectormenu;
                mDesconectar($conexion);
            }
            else
            {
                foreach ($_SESSION['$vectormenu'] as $item )
                {
                    ?>
                    <li>
                        <a href="<?php echo $item['nombre_pagina']?>">
                        	<i class="<?php echo $item['logo']?>"></i>
                        	<?php echo $item['etiqueta']?>
                       	</a>
                    </li> 
                    <?php                  
                }
            }
        ?>             
    </ul>       
</nav>