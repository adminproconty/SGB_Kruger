<?php
session_start();
date_default_timezone_set('America/Bogota');

require_once "../../config/database.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])){
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
}

else {
    if ($_GET['act']=='insert') {
        if (isset($_POST['Guardar'])) {	
		   //Datos para el LOG
		   $fecha_log = date('Y-m-d H:i:s');
		   $usuario_log = $_SESSION['id_user'];

			//obtenemos el archivo .csv
			$tipo = $_FILES['archivo']['type'];
			$tamanio = $_FILES['archivo']['size'];
			$archivotmp = $_FILES['archivo']['tmp_name'];
			//cargamos el archivo
			$lineas = file($archivotmp);
			//inicializamos variable a 0, esto nos ayudará a indicarle que no lea la primera línea
			$i=0;
			//Recorremos el bucle para leer línea por línea
			foreach ($lineas as $linea_num => $linea)
			{ 
			   if($i != 0) 
			   { 
				   //abrimos condición, solo entrará en la condición a partir de la segunda pasada del bucle.
				   /* La funcion explode nos ayuda a delimitar los campos, por lo tanto irá 
				   leyendo hasta que encuentre un ; */
				   $datos = explode(";",$linea);
					//INICIA DEUDORES
					if ($_POST['tipo_archivos']=='Deudores') {
					   $tipo_documento = utf8_encode($datos[0]);
					   $numero_identificacion = utf8_encode($datos[1]);
					   $nombre_completo = utf8_encode($datos[2]);
					   $apellidos = utf8_encode($datos[3]);
					   $nombres = utf8_encode($datos[4]);
					   $agencia = utf8_encode($datos[5]);
					   $plaza = $datos[6];
					   $provincia = $datos[7];
					   $sexo = utf8_encode($datos[8]);
					   $estado_civil = utf8_encode($datos[9]);
					   $profesion = utf8_encode($datos[10]);
					   $actividad_economica = utf8_encode($datos[11]);
					   $usuario_asignado = utf8_encode($datos[12]);
					   
					   //validamos si existe el registro
							$query_new = mysqli_query($mysqli,"UPDATE deudores SET actual = 'NO',
																	user_registro = '$usuario_log'
															   WHERE numero_identificacion = '$numero_identificacion' and actual = 'SI'") 
							or die('error '.mysqli_error($mysqli));							  
							
							$query = mysqli_query($mysqli,"INSERT INTO deudores(tipo_documento,numero_identificacion,nombre_completo,apellidos,nombres,agencia,plaza,provincia,sexo,estado_civil,profesion,actividad_economica,fecha_registro,user_registro,actual) 
														  VALUES('$tipo_documento','$numero_identificacion','$nombre_completo','$apellidos','$nombres','$agencia',$plaza,$provincia,'$sexo','$estado_civil','$profesion','$actividad_economica','$fecha_log','$usuario_asignado','SI')")
														  or die('error '.mysqli_error($mysqli));
					} //FIN DEUDORES	
					
					//INICIA CREDITOS
					if ($_POST['tipo_archivos']=='Creditos') {
					
					   $tipo_documento = utf8_encode($datos[0]);
					   $numero_identificacion = utf8_encode($datos[1]);
					   $numero_operacion = utf8_encode($datos[2]);
					   $monto_deuda = str_replace(',', '', mysqli_real_escape_string($mysqli, trim($datos[3])));
					   $cuota_mas_vencido = $datos[4];
					   $cuotas_vencidas = $datos[5];
					   $tasa_credito = trim($datos[6]);
					   $fecha_creacion = date('Y/m/d',strtotime(str_replace("/", "-", $datos[7])));
					   $tipo_credito = utf8_encode($datos[8]);
					   $fecha_vencimiento = date('Y/m/d',strtotime(str_replace("/", "-", $datos[9])));
					   $estado_operacion = $datos[10];
					   $total_pagar = str_replace(',', '', mysqli_real_escape_string($mysqli, trim($datos[11])));
					   $descripcion = utf8_encode($datos[12]);
					   $nombre_agencia = utf8_encode($datos[13]);
					   $plazo = $datos[14];

					   
					   
					   //validamos si existe el registro
							$query_new = mysqli_query($mysqli,"UPDATE creditos SET actual = 'NO',
																	user_registro = '$usuario_log'
															   WHERE numero_identificacion = '$numero_identificacion' and actual = 'SI'") 
							or die('error '.mysqli_error($mysqli));							  
							
							$query = mysqli_query($mysqli,"INSERT INTO creditos(tipo_documento,numero_identificacion,numero_operacion,monto_deuda,cuota_mas_vencido,cuotas_vencidas,tasa_credito,fecha_creacion,tipo_credito,fecha_vencimiento,estado_operacion,total_pagar,descripcion,nombre_agencia,plazo,fecha_registro,user_registro,actual) 
														  VALUES('$tipo_documento','$numero_identificacion','$numero_operacion',$monto_deuda,$cuota_mas_vencido,$cuotas_vencidas,'$tasa_credito','$fecha_creacion','$tipo_credito','$fecha_vencimiento',$estado_operacion,'$total_pagar','$descripcion','$nombre_agencia',$plazo,'$fecha_log','$usuario_log','SI')")
														  or die('error '.mysqli_error($mysqli));
					} //FIN CREDITOS	
			   
					//INICIA CUOTAS
					if ($_POST['tipo_archivos']=='Cuotas') {
					
					   $tipo_documento = utf8_encode($datos[0]);
					   $numero_identificacion = utf8_encode($datos[1]);
					   $numero_operacion = utf8_encode($datos[2]);
					   $numero_cuota = $datos[3];
					   $capital_cuota = str_replace(',', '', mysqli_real_escape_string($mysqli, trim($datos[4])));
					   $interes = str_replace(',', '', mysqli_real_escape_string($mysqli, trim($datos[5])));
					   $comision1 = str_replace(',', '', mysqli_real_escape_string($mysqli, trim($datos[6])));
					   $comision2 = str_replace(',', '', mysqli_real_escape_string($mysqli, trim($datos[7])));
					   $fecha_vencimiento = date('Y/m/d',strtotime(str_replace("/", "-", $datos[8])));
					   $interes_cuota = str_replace(',', '', mysqli_real_escape_string($mysqli, trim($datos[9])));
					   $interes_mora = str_replace(',', '', mysqli_real_escape_string($mysqli, trim($datos[10])));
					   if($datos[11]==''){
						$calculo_mora = 0;   
					   }else{
						$calculo_mora = $datos[11];
					   }						   
					   
					   if($datos[12]==''){
						$valor_mora = 0;   
					   }else{
						$valor_mora = str_replace(',', '', mysqli_real_escape_string($mysqli, trim($datos[12])));
					   }
					   
					   $tipo_credito = utf8_encode($datos[13]);
					   
					   //validamos si existe el registro
							$query_new = mysqli_query($mysqli,"UPDATE cuotas SET actual = 'NO',
																	user_registro = '$usuario_log'
															   WHERE numero_identificacion = '$numero_identificacion' and actual = 'SI'") 
							or die('error '.mysqli_error($mysqli));							  
							
							$query = mysqli_query($mysqli,"INSERT INTO cuotas(tipo_documento,numero_identificacion,numero_operacion,numero_cuota,capital_cuota,interes,comision1,comision2,fecha_vencimiento,interes_cuota,interes_mora,calculo_mora,valor_mora,tipo_credito,fecha_registro,user_registro,actual) 
														  VALUES('$tipo_documento','$numero_identificacion','$numero_operacion',$numero_cuota,$capital_cuota,$interes,$comision1,$comision2,$fecha_vencimiento,$interes_cuota,$interes_mora,$calculo_mora,$valor_mora,'$tipo_credito','$fecha_log','$usuario_log','SI')")
														  or die('error '.mysqli_error($mysqli));
					} //FIN CUOTAS	
	
					//INICIA DIRECCIONES
					if ($_POST['tipo_archivos']=='Direcciones') {
					   $tipo_documento = utf8_encode($datos[0]);
					   $numero_identificacion = utf8_encode($datos[1]);
					   $direccion = utf8_encode($datos[2]);
					   $tipo_direccion = utf8_encode($datos[3]);
					   $provincia = $datos[4];
					   $ciudad = $datos[5];

					   
					   //validamos si existe el registro
						//	$query_new = mysqli_query($mysqli,"UPDATE direcciones SET actual = 'NO',
						//											user_registro = '$usuario_log'
						//									   WHERE numero_identificacion = '$numero_identificacion' and actual = 'SI'") 
						//	or die('error '.mysqli_error($mysqli));							  
							
							$query = mysqli_query($mysqli,"INSERT INTO direcciones(tipo_documento,numero_identificacion,direccion,tipo_direccion,provincia,ciudad,fecha_registro,user_registro,actual) 
														  VALUES('$tipo_documento','$numero_identificacion','$direccion','$tipo_direccion',$provincia,$ciudad,'$fecha_log','$usuario_log','SI')")
														  or die('error '.mysqli_error($mysqli));
					} //FIN DIRECCIONES
	
					//INICIA REFERENCIAS
					if ($_POST['tipo_archivos']=='Referencias') {
					   $tipo_documento = utf8_encode($datos[0]);
					   $numero_identificacion = utf8_encode($datos[1]);
					   $numero_identificacion_ref = utf8_encode($datos[2]);
					   $nombre = utf8_encode($datos[3]);
					   $telefono = utf8_encode($datos[4]);
					   $tipo_referencia = utf8_encode($datos[5]);
					   

					   
					   //validamos si existe el registro
						//	$query_new = mysqli_query($mysqli,"UPDATE referencias SET actual = 'NO',
						//											user_registro = '$usuario_log'
						//									   WHERE numero_identificacion = '$numero_identificacion' and actual = 'SI'") 
						//	or die('error '.mysqli_error($mysqli));							  
							
							$query = mysqli_query($mysqli,"INSERT INTO referencias(tipo_documento,numero_identificacion,numero_identificacion_ref,nombre,telefono,tipo_referencia,fecha_registro,user_registro,actual) 
														  VALUES('$tipo_documento','$numero_identificacion','$numero_identificacion_ref','$nombre','$telefono','$tipo_referencia','$fecha_log','$usuario_log','SI')")
														  or die('error '.mysqli_error($mysqli));
					} //FIN REFERENCIAS
	
					//INICIA TELEFONOS
					if ($_POST['tipo_archivos']=='Telefonos') {
					   $tipo_documento = utf8_encode($datos[0]);
					   $numero_identificacion = utf8_encode($datos[1]);
					   $numero_telefono = utf8_encode($datos[2]);
					   $tipo_telefono = utf8_encode($datos[3]);
					   

					   
					   //validamos si existe el registro
						//	$query_new = mysqli_query($mysqli,"UPDATE telefonos SET actual = 'NO',
						//											user_registro = '$usuario_log'
						//									   WHERE numero_identificacion = '$numero_identificacion' and actual = 'SI'") 
						//	or die('error '.mysqli_error($mysqli));							  
							
							$query = mysqli_query($mysqli,"INSERT INTO telefonos(tipo_documento,numero_identificacion,numero_telefono,tipo_telefono,fecha_registro,user_registro,actual) 
														  VALUES('$tipo_documento','$numero_identificacion','$numero_telefono','$tipo_telefono','$fecha_log','$usuario_log','SI')")
														  or die('error '.mysqli_error($mysqli));
					} //FIN TELEFONOS
	
					//INICIA PAGOS
					if ($_POST['tipo_archivos']=='Pagos') {
					
					   $numero_identificacion = utf8_encode($datos[0]);
					   $numero_operacion = utf8_encode($datos[1]);
					   $cuota = $datos[2];
					   $fecha_vencimiento = date('Y/m/d',strtotime(str_replace("/", "-", $datos[3])));
					   $fecha_pago = date('Y/m/d',strtotime(str_replace("/", "-", $datos[4])));
					   $valor1 = str_replace(',', '', mysqli_real_escape_string($mysqli, trim($datos[5])));
					   $valor2 = str_replace(',', '', mysqli_real_escape_string($mysqli, trim($datos[6])));
					   $valor3 = str_replace(',', '', mysqli_real_escape_string($mysqli, trim($datos[7])));
					   $valor4 = str_replace(',', '', mysqli_real_escape_string($mysqli, trim($datos[8])));
					   $valor5 = str_replace(',', '', mysqli_real_escape_string($mysqli, trim($datos[9])));
					   $valor6 = str_replace(',', '', mysqli_real_escape_string($mysqli, trim($datos[10])));
					   $origen_pago = utf8_encode($datos[11]);
					   $tipo_transaccion = utf8_encode($datos[12]);
					   $valor7 = str_replace(',', '', mysqli_real_escape_string($mysqli, trim($datos[13])));
					   $valor8 = str_replace(',', '', mysqli_real_escape_string($mysqli, trim($datos[14])));
					   $valor_pago = str_replace(',', '', mysqli_real_escape_string($mysqli, trim($datos[15])));
					   $dias_mora = $datos[16];
					   
					   
					   //validamos si existe el registro
							//$query_new = mysqli_query($mysqli,"UPDATE pagos SET actual = 'NO',
							//										user_registro = '$usuario_log'
							//								   WHERE numero_identificacion = '$numero_identificacion' and actual = 'SI'") 
							//or die('error '.mysqli_error($mysqli));							  
							
							$query = mysqli_query($mysqli,"INSERT INTO pagos(numero_identificacion,numero_operacion,cuota,fecha_vencimiento,fecha_pago,valor1,valor2,valor3,valor4,valor5,valor6,origen_pago,tipo_transaccion,valor7,valor8,valor_pago,dias_mora,fecha_registro,user_registro,actual) 
														  VALUES('$numero_identificacion','$numero_operacion',$cuota,'$fecha_vencimiento','$fecha_pago',$valor1,$valor2,$valor3,$valor4,$valor5,$valor6,'$origen_pago','$tipo_transaccion',$valor7,$valor8,$valor_pago,$dias_mora,'$fecha_log','$usuario_log','SI')")
														  or die('error '.mysqli_error($mysqli));
					} //FIN PAGOS
			   
			   } //cerramos condición
			   $i++;
			}

			$codigo_log = $_POST['codigo'];
			$tipo_archivos_log = $_POST['tipo_archivos'];
			$registros_log = $i - 1;
			
			$query_log = mysqli_query($mysqli,"INSERT INTO cargas(codigo,tipo_archivos,usuario,fecha,registros) 
												  VALUES('$codigo_log','$tipo_archivos_log','$usuario_log','$fecha_log',$registros_log)")
												  or die('error '.mysqli_error($mysqli));
			
			if ($query_log) {
				//header("location: ../../main.php?module=cargadata&alert=1");
				echo "<script language=Javascript> location.href=\"../../main.php?module=cargadata&alert=1\"; </script>"; 
			}
							   
		}   
    }
}       
?>