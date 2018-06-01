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

		// escaping, additionally removing everything that could be (html/javascript-) code

		$documento=mysqli_real_escape_string($con,(strip_tags($_POST["q"],ENT_QUOTES)));
        $fecha_hoy=date('Y-m-d H:i:s');
		
		$sql="UPDATE clientes SET `fec_real_consumo`= '$fecha_hoy' WHERE documento_cliente = $documento";

		$query_new_insert = mysqli_query($con,$sql);

			if ($query_new_insert){

				$messages[] = "Cliente ha sido ingresado satisfactoriamente. $fecha_hoy";

			} else{

				$errors []= "$fecha_hoy Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);

			}

		} else {

			$errors []= "Error desconocido.";

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

						<strong>¡Bien hecho!</strong>

						<?php

							foreach ($messages as $message) {

									echo $message;

								}

							?>

				</div>

				<?php

			}



?>