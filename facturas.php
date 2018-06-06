<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	
	$active_facturas="active";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$active_reportes="";
	$title="Consumos | SGB";

	include('ajax/is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	$session_id= session_id();
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	$delete=mysqli_query($con, "DELETE FROM tmp WHERE session_id='".$session_id."'");

	
?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<?php include("head.php");?>

  </head>
  <body>
	<?php
	include("navbar.php");
	?>  
    <div class="container">
		<div class="panel panel-info">
		<div class="panel-heading">

			<h4><i class='glyphicon glyphicon-search'></i> Registrar Consumo</h4>
		</div>
			<div class="panel-body">
			<?php
                  
            ?>
				<form class="form-horizontal" method="post" id="consumos" name="consumos">
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Documento</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" onkeyup='load(1);' autofocus autocomplete="off">
							</div>
							<div class="col-md-3">
							<button type="button" class="btn btn-default" onclick='load(1);' style="display: none;">
							<span class="glyphicon glyphicon-search" ></span> Buscar</button>
							<span id="loader"></span>
						</div>
						</div>
						
			</form>
			
			<div class="for-group row" id="form_mensajes">
				<div id="mensajes"></div><!-- Carga los datos ajax --> 
            </div>
			
			
				<div id="resultados"></div><!-- Carga los datos ajax -->
				<div class='outer_div'></div><!-- Carga los datos ajax -->
			</div>
		</div>	
	</div>
	<hr>
	<?php
	include("footer.php");
	?>
	
	<script type="text/javascript" src="js/consumos.js"></script>

  </body>
</html>