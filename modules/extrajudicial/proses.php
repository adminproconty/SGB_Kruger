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
     
            $id_deudores  = mysqli_real_escape_string($mysqli, trim($_POST['id_deudores']));
			$numero_identificacion  = mysqli_real_escape_string($mysqli, trim($_POST['numero_identificacion']));
            $numero_operacion  = mysqli_real_escape_string($mysqli, trim($_POST['numero_operacion']));
			$cedente = 'FINCA';
			$accion  = mysqli_real_escape_string($mysqli, trim($_POST['accion']));
			$respuesta  = mysqli_real_escape_string($mysqli, trim($_POST['respuesta']));
            $contacto  = mysqli_real_escape_string($mysqli, trim($_POST['contacto']));
			$telefono  = mysqli_real_escape_string($mysqli, trim($_POST['telefono']));
			$observacion  = mysqli_real_escape_string($mysqli, trim($_POST['observacion']));
			$fecha_gestion  = date('Y-m-d H:i:s');
			if ($_POST['fechas']){
			$fecha_seguimiento  = mysqli_real_escape_string($mysqli, trim($_POST['fechas']));
			}else{
			  $fecha_seguimiento  = "";
			}
			$valor_compromiso = mysqli_real_escape_string($mysqli, trim($_POST['valor']));
			
			$usuario = $_SESSION['id_user'];

  
            $query = mysqli_query($mysqli, "INSERT INTO gestionextrajudicial(numero_identificacion,numero_operacion,cedente,accion,respuesta,contacto,telefono,observacion,fecha_gestion,valor_compromiso,usuario,fecha_seguimiento) 
                                            VALUES('$numero_identificacion','$numero_operacion','$cedente','$accion','$respuesta','$contacto','$telefono','$observacion','$fecha_gestion','$valor_compromiso','$usuario','$fecha_seguimiento')")
                                            or die('error '.mysqli_error($mysqli));    
											
			$estado = mysqli_real_escape_string($mysqli, trim($_POST['estado']));
			
			$query2 = mysqli_query($mysqli, "UPDATE deudores SET  estado       = '$estado'
                                                      WHERE iddeudores = $id_deudores")
                                                or die('error: '.mysqli_error($mysqli));
			
            if ($query) {
         
                //header("location: ../../main.php?module=extrajudicial&alert=1");
				echo "<script language=Javascript> location.href=\"../../main.php?module=extrajudicial&alert=1\"; </script>"; 
            }   
        }   
    }
    
    elseif (isset($_POST['modalGestion'])) {
       
            
			$id_gestion  = trim($_POST['id_gestion']);
			$accion  = trim($_POST['accion']);
			$respuesta  = trim($_POST['respuesta']);
            $contacto  = trim($_POST['contacto']);
			$telefono  = trim($_POST['telefono']);
			$observacion  = trim($_POST['observacion']);
			$fecha_gestion  = date('Y-m-d H:i:s');
			if ($_POST['fechas']){
			$fecha_seguimiento  = trim($_POST['fechas']);
			}else{
			  $fecha_seguimiento  = "";
			}
			$valor_compromiso = trim($_POST['valor']);
			$usuario = $_SESSION['id_user'];

                $query = mysqli_query($mysqli, "UPDATE gestionextrajudicial SET  accion       = '$accion',
                                                                    respuesta      = '$respuesta',
                                                                    contacto      = '$contacto',
                                                                    telefono          = '$telefono',
                                                                    observacion    = '$observacion',
																	fecha_gestion    = '$fecha_gestion',
																	valor_compromiso    = '$valor_compromiso',
																	usuario    = '$usuario',
																	fecha_seguimiento    = '$fecha_seguimiento'
																	
                                                              WHERE idgestionextrajudicial       = '$id_gestion'")
                                                or die('error: '.mysqli_error($mysqli));

    
                if ($query) {
					echo "<script language=Javascript> location.href=\"../../main.php?module=extrajudicial&alert=1\"; </script>"; 
                }         
        
		echo "<script language=Javascript> location.href=\"../../main.php?module=extrajudicial&alert=1\"; </script>"; 

    }

    elseif ($_GET['act']=='delete') {
        if (isset($_GET['id'])) {
            $codigo = $_GET['id'];
      
            $query = mysqli_query($mysqli, "DELETE FROM medicamentos WHERE codigo='$codigo'")
                                            or die('error '.mysqli_error($mysqli));


            if ($query) {
     
                header("location: ../../main.php?module=medicines&alert=3");
            }
        }
    }       
}       
?>