<?php
ob_start();
require '../php_util/parametros.php';
require '../php_util/sesion.php';

session_start();
mValidarSesion();
mValidarTimeOut();

$fechaConsulta=date("Y-m-d");
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Registro de Pedidos</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="../../css/custom.css">
<link rel="stylesheet" href="../../css/main.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script src="../../js/script_edit_pedidos.js"></script>
</head>
<body> 
    <div class="wrapper" >
        <!-- menu --> 
        <?php include ("menu.php"); ?>   
    
    	<!-- Page Content  -->
        <div id="content">
            <!-- barra menu   -->
            <?php include ("menu_navbar.php"); ?>
            
            <!-- pagina  -->            
            <div class="container">        
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-6 ">
        						<h2>Administrar <b>Pedidos</b></h2>
        					</div>
        					<div hidden class="col-sm-6 ">
        						<a href="#addClienteModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Agregar nuevo pedido</span></a>
        					</div>
                        </div>
                    </div>
        			<div class='col-sm-4 pull-right'>
        				<div id="custom-search-input">
                            <div class="input-group col-md-12">
                                <input type="date" class="form-control" id="qfd" title="fecha consulta" onchange="consultar(1);" value="<?php echo $fechaConsulta;?>"/>
                                <span class="input-group-btn">
                                    <button class="btn btn-secondary" type="button" onclick="consultar(1);">
                                        <span class="fa fa-search"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
        			</div>
        			<div class='clearfix'></div>
        			<hr>
        			<div id="loader"></div><!-- Carga de datos ajax aqui -->
        			<div id="resultados"></div><!-- Carga de datos ajax aqui -->
        			<div class='outer_div'></div><!-- Carga de datos ajax aqui -->		
                </div>
            </div> 
        </div>        
    </div>       
    
    <!-- Notificacion  -->
    <?php include ("menu_notificacion.php"); ?>
    
	<script src="../../js/script_pedidos.js"></script>
	<script src="../../js/main.js"></script>
</body>
</html>