<?php
   date_default_timezone_set('America/Bogota');
   include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
   /*Inicia validacion del lado del servidor*/
   	if (empty($_POST['q'])) {
          $errors[] = "Nombre vacío";
	} else if (!empty($_POST['q'])){
			/* Connect To Database*/
			require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
			require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
			$documento=mysqli_real_escape_string($con,(strip_tags($_POST["q"],ENT_QUOTES)));
			$fecha_valida=date('Y-m-d');
			   
			//VALIDA SI ES CODIGO MAESTRO
   
   			$valida_consumo = 0;
			$sql_valida1=mysqli_query($con,"SELECT count(*) as esmaestro, id_cliente FROM  codigos_maestros, clientes where codigo_maestro = '$documento' and documento_cliente = codigo_maestro");
			$row2= mysqli_fetch_array($sql_valida1);
			$esmaestro = $row2['esmaestro'];
    		if ($esmaestro == 0){
   				$valida_consumo = 1; //VALIDA OTRAS REGLAS 
       		} else { 
				$valida_consumo = 0; //NO VALIDA NADA Y REGISTRA CONSUMO
				$puedecomer = 1;
				$id_cliente = $row2['id_cliente'];
    		}
			
			//SI NO ES COD MAESTRO VALIDA CONSUMO Y REGISTRO DEL DIA
			if ($valida_consumo == 1){
				$sql_existe=mysqli_query($con,"SELECT CLI.id_cliente, 
										(SELECT COUNT(CON.id_consumos) FROM consumos_diarios CON WHERE CON.id_cliente = CLI.id_cliente) as comio
										FROM CLIENTES CLI WHERE CLI.documento_cliente = '$documento' and date_format(CLI.fec_consumo,'%Y-%m-%d') = '$fecha_valida'");
				$row_valida= mysqli_fetch_array($sql_existe);
				$id_cliente = $row_valida['id_cliente'];
				$registra_consumo = $row_valida['comio'];
			}
               
			if ($id_cliente <= 0){
				$errors []= "No existe un registro de hoy para el Id: $documento";     
			} elseif ($registra_consumo > 0 ) {
				$alerts []= "Ya existe un registro de hoy para el Id: $documento";
			} else {
				$puedecomer = 1;
			}
   
    
            if ($puedecomer == 1){
                $fecha_hoy=date('Y-m-d H:i:s');
                $sql="INSERT INTO `consumos_diarios`(`id_cliente`, `fecha_consumo`, `estado`, `fecha_cambio`, `user_cambio`) VALUES ($id_cliente,'$fecha_hoy',1,'','')";
                $query_new_insert = mysqli_query($con,$sql);
                if ($query_new_insert){
?>
					<script languaje="javascript">
						var id_cliente = <?php echo $id_cliente; ?>;
						window.open('./pdf/documentos/ver_factura.php?id_cliente='+id_cliente,'Factura','width=200,height=100');
					</script>
<?php
					$messages[] = "Consumo Registrado Exitosamente: $fecha_hoy";
						
				} else{
					$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
				}
			}
	}		
			
   if (isset($errors)){
   ?>
<div class="alert alert-danger" role="alert">
   <button type="button" class="close" data-dismiss="alert">&times;</button>
   <strong>Error!</strong> 
   <?php
      foreach ($errors as $error) {
      		echo $error;
      	}
      ?>
</div>
<?php
   }
   
   if (isset($messages)){
   		?>
<div class="alert alert-success" role="alert">
   <button type="button" class="close" data-dismiss="alert">&times;</button>
   <strong>¡Buen Provecho!</strong>
   <?php
      foreach ($messages as $message) {
      		echo $message;
      	}
      ?>
</div>
<?php
   }
   
            if (isset($alerts)){
   	?>
<div class="alert alert-warning" role="alert">
   <button type="button" class="close" data-dismiss="alert">&times;</button>
   <strong>¡Advertencia!</strong>
   <?php
      foreach ($alerts as $alerts) {
      		echo $alerts;
      	}
      ?>
</div>
<?php
   }
   
   ?>
