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
	
	
	$sql=mysqli_query($con,"SELECT b.id_cliente as id_cliente, a.nombre_cliente as nombre_cliente, a.documento_cliente as documento_cliente
							, a.menu_cliente as menu_cliente, b.fecha_consumo as fecha_consumo 
						FROM  consumos_diarios b, clientes a 
						where a.id_cliente = '".$id_cliente."'
						and a.id_cliente  
						and b.estado = 1
						and b.user_cambio = 'NORMAL'
						UNION
						SELECT co.id_cliente as id_cliente, cod.nombre_maestro as nombre_cliente, cod.codigo_maestro as documento_cliente
						, '' as menu_cliente, co.fecha_consumo as fecha_consumo 
						from  codigos_maestros cod, consumos_diarios co 
						where co.id_cliente = cod.id_codigo
						and co.estado = 1
						and co.user_cambio = 'MAESTRO' 
						and co.id_cliente = '".$id_cliente."'");
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
						location.reload();
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
					<FONT FACE="Arial" SIZE="3">En Kruger tu importas!</FONT>
					</td>
				</tr>
				<tr>
					<td>
					<FONT FACE="Arial" SIZE="3"><?php echo $nombre_cliente ?></FONT>
					</td>
				</tr>
				<tr>
					<td>
					<FONT FACE="Arial" SIZE="3">Menú: <?php echo $menu_cliente ?></FONT>
					</td>
				</tr>
				<tr>
					<td>
					<FONT FACE="Arial" SIZE="3"><?php echo $fecha_consumo ?></FONT>
					</td>
				</tr>

			
		</body>
	</html>



	