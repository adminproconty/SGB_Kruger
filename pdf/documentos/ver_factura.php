﻿<?php

	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: ../../login.php");
		exit;
    }
	
	/* Connect To Database*/
	include("../../config/db.php");
	include("../../config/conexion.php");
	//Archivo de funciones PHP
	include("../../funciones.php");
	$session_id= session_id();
	

	require_once(dirname(__FILE__).'/../html2pdf.class.php');
	//Variables por GET
	$id_cliente=intval($_GET['id_cliente']);
	//Fin de variables por GET
	
	$sql=mysqli_query($con,"select * from consumos_diarios a, clientes b where a.id_cliente = b.id_cliente and a.id_cliente='".$id_cliente."'");
	while ($row=mysqli_fetch_array($sql))
	{
		$nombre_cliente=$row['nombre_cliente'];
		$fecha_consumo=$row['fecha_consumo'];
		$menu_cliente=$row['menu_cliente'];
	}
?>

	<!DOCTYPE html>
	<html>
		<head>
			<meta charset="UTF-8">
			<title></title>
			<script type="text/javascript">
				function imprimir() {
					if (window.print) {
						window.print();
						window.location.href = "../../facturas.php"
						window.close();
					} else {
						alert("La función de impresion no esta soportada por su navegador.");
					}
				}
			</script>
		</head>
		<body onload="imprimir();">
			<table style="width: 100%;">
				<tr>
					<td>
<<<<<<< HEAD
					<FONT FACE="Arial" SIZE="3">En Kruger tu importas!</FONT>
=======
					<FONT FACE="Arial" SIZE="2">En Kruger tu importas!</FONT>
>>>>>>> aa4c20da34da412b5d6ff8241ec8863e96f736a2
					</td>
				</tr>
				<tr>
					<td>
<<<<<<< HEAD
					<FONT FACE="Arial" SIZE="3"><?php echo $nombre_cliente ?></FONT>
=======
					<FONT FACE="Arial" SIZE="2"><?php echo $nombre_cliente ?></FONT>
>>>>>>> aa4c20da34da412b5d6ff8241ec8863e96f736a2
					</td>
				</tr>
				<tr>
					<td>
<<<<<<< HEAD
					<FONT FACE="Arial" SIZE="3">Menú: <?php echo $menu_cliente ?></FONT>
=======
					<FONT FACE="Arial" SIZE="2">Menú: <?php echo $menu_cliente ?></FONT>
>>>>>>> aa4c20da34da412b5d6ff8241ec8863e96f736a2
					</td>
				</tr>
				<tr>
					<td>
<<<<<<< HEAD
					<FONT FACE="Arial" SIZE="3"><?php echo $fecha_consumo ?></FONT>
=======
					<FONT FACE="Arial" SIZE="2"><?php echo $fecha_consumo ?></FONT>
>>>>>>> aa4c20da34da412b5d6ff8241ec8863e96f736a2
					</td>
				</tr>

			
		</body>
	</html>



	