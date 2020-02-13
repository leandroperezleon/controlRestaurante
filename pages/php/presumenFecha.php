<?php
ob_start();
require '../php_util/parametros.php';
require '../php_util/sesion.php';

session_start();
mValidarSesion();
mValidarTimeOut();

ob_end_flush();
?>

<?php 
/** Actual month last day **/
function _data_last_month_day() {
    $month = date('m');
    $year = date('Y');
    $day = date("d", mktime(0,0,0, $month+1, 0, $year));
    
    return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
};

/** Actual month first day **/
function _data_first_month_day() {
    $month = date('m');
    $year = date('Y');
    return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
}

$fechaInicioMes=_data_first_month_day();
$fechaFinMes= _data_last_month_day();

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Resumen Pedidos por rango fecha</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="../../css/custom.css">
<link rel="stylesheet" href="../../css/main.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>
<body> 
    
    <div class="wrapper" >
        <!-- menu --> 
        <?php include ("menu_header.php"); ?>   
    
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
        						<h2>Resumen Pedidos por <b>rango fecha</b></h2>
        					</div>
        					<div hidden class="col-sm-6">
        						<a href="#addClienteModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Agregar nuevo cliente</span></a>
        					</div>
                        </div>
                    </div>        	
                	
                	<div class='col-xl-5 col-lg-7 col-md-9 col-sm-12 pull-right'>
        				<div id="custom-search-input">
                            <div class="input-group">
                                <div class="form-group row">
                                	<div class="col-xl-5 col-lg-5 col-md-5">
                                		<input type="date" class="form-control" placeholder="Fecha desde"  id="qfd" title="fecha desde" value="<?php echo $fechaInicioMes;?>"/>
                                	</div>
                                    <div class="col-xl-5 col-lg-5 col-md-5">
                                    	<input type="date" class="form-control"  placeholder="Fecha hasta"  id="qfh" title="fecha hasta" value="<?php echo $fechaFinMes;?>"/>
                                    </div>
                                    <span class="input-group-btn col-xl-2 col-lg-2 col-md-2">
                                        <button class="btn btn-info" type="button" onclick="load(1);">
                                            <span class="fa fa-search"></span>
                                        </button>
                                    </span>                     
                                </div>                                               
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
    
	<script src="../../js/script_resumenFecha.js"></script>
	<script src="../../js/main.js"></script>
</body>
</html>