<?php
    date_default_timezone_set('America/Bogota');
    include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
    /*Inicia validacion del lado del servidor*/
    /* Connect To Database*/
    require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
    require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
    // escaping, additionally removing everything that could be (html/javascript-) code
    $fecha_log = date('Y-m-d H:i:s');
    //obtengo usuario
     $usuario_log=$_SESSION['user_id'];
     
     $codigo_log = $_POST['codigo'];
    
    //obtenemos el archivo .csv
    $tipo = $_FILES['archivo']['type'];
    $tamanio = $_FILES['archivo']['size'];
    $archivotmp = $_FILES['archivo']['tmp_name'];
    //cargamos el archivo
    $lineas = file($archivotmp);
    //inicializamos variable a 0, esto nos ayudará a indicarle que no lea la primera línea
    $i=0;
    //Recorremos el bucle para leer línea por línea
    foreach ($lineas as $linea_num => $linea){ 
        if($i != 0){ 
            //abrimos condición, solo entrará en la condición a partir de la segunda pasada del bucle.
            /* La funcion explode nos ayuda a delimitar los campos, por lo tanto irá 
            leyendo hasta que encuentre un ; */
            $datos = explode(";",$linea);
            //INICIA CARGA
            $nombre_cliente = utf8_encode($datos[0]);
            $documento_cliente = utf8_encode($datos[1]);
            $telefono_cliente = utf8_encode($datos[2]);
            $email_cliente = utf8_encode($datos[3]);
            $fec_consumo = date('Y/m/d',strtotime(str_replace("/", "-", $datos[4])));
            $menu_cliente = utf8_encode($datos[5]);
            $date_added=date("Y-m-d H:i:s");
            
            
            $sql_update = "INSERT INTO `clientes`(`nombre_cliente`, `documento_cliente`, `telefono_cliente`, `email_cliente`, `direccion_cliente`, `status_cliente`, `date_added`, `codigo`, `saldo_cliente`, `empresa_cliente`, `fec_consumo`, `menu_cliente`,`id_carga`) 
            VALUES ('$nombre_cliente','$documento_cliente','$telefono_cliente','$email_cliente','','','$date_added','','0','','$fec_consumo','$menu_cliente','$codigo_log')";

            $query_new_insert = mysqli_query($con,$sql_update);
            if ($query_new_insert){
                $messages = "Carga ingresada satisfactoriamente.";
                
			} else{
				$errors = "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
            
        //FIN CARGA
        } //cerramos condición
        $i++;
    }
    if (isset($errors)){

			

        ?>

        <div class="alert alert-danger" role="alert">

            <button type="button" class="close" data-dismiss="alert">&times;</button>

                <strong>Error!</strong> 

                <?php

                    
                            echo $errors;


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

                                $codigo_log = $_POST['codigo'];
                                $registros_log = $i - 1;
                                $sql_log = "INSERT INTO cargas(codigo,usuario,fecha,registros) 
                                VALUES('$codigo_log','$usuario_log','$fecha_log',$registros_log)";
                                $query_new_insert = mysqli_query($con,$sql_log);
                                echo $messages;


                        ?>

            </div>

            <?php

        }
        
?>
