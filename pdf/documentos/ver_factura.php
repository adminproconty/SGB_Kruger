<?php

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
						//window.location.href = "../../nueva_factura.php"
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
					<FONT FACE="Arial" SIZE="1">Nombre: <?php echo $nombre_cliente ?></FONT>
					</td>
				</tr>

			<table style="width: 100%;">
				<tr>
					<td>
						<FONT FACE="Arial" SIZE="1">--------------------------------------------------------</FONT>
					</td>
				</tr>
			</table>
		</body>
	</html>



	