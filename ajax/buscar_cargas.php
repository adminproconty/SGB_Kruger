<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos

	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

	if (isset($_GET['id'])){
		$id_carga=intval($_GET['id']);

		//OBTENGO CODIGO DE CARGA
		$query_id = mysqli_query($con, "SELECT RIGHT(codigo,6) as codigo FROM cargas
                                                    ORDER BY codigo DESC LIMIT 1")
                                                    or die('error '.mysqli_error($mysqli));

                $count = mysqli_num_rows($query_id);

                if ($count <> 0) {
                
                    $data_id = mysqli_fetch_assoc($query_id);
                    $codigo    = $data_id['codigo'];
                } 
				$buat_id   = str_pad($codigo, 6, "0", STR_PAD_LEFT);
				$codigo = "C$buat_id";
				
		$query=mysqli_query($con, "select * 
			from clientes cli, consumos_diarios con where cli.id_cliente = con.id_cliente
			and cli.id_carga ='".$codigo."'");

		$count=mysqli_num_rows($query);
		if ($count==0){
			if ($delete1=mysqli_query($con,"DELETE FROM cargas WHERE id_carga='".$id_carga."'") and $delete2=mysqli_query($con, "delete from clientes where id_carga='".$codigo."'")){

			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente.
			</div>
			<?php 
            }else {
                ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
                </div>
                <?php
            }
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo eliminar éste  cliente. Existen consumos vinculados a éste producto. 
			</div>

			<?php
		}
	}

	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('codigo', 'fecha');//Columnas de busqueda
		 $sTable = "cargas car";
		 $sWhere = "";
  		 if ( $_GET['q'] != "" ){
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ ){
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}

		$sWhere.=" order by codigo DESC";
		include 'pagination.php'; //include pagination file
		//pagination variables

		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;

		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './cargas.php';

		//main query to fetch the data

		$sql="SELECT car.*,
            (select user_name from users where user_id = car.usuario) as usuario
	        FROM  $sTable $sWhere 
            LIMIT $offset,$per_page";

		$query = mysqli_query($con, $sql);

		//loop through fetched data

		if ($numrows>0){
			?>
			<div class="table-responsive">
			  <table class="table">
                <tr  class="info">
                    <th class="center">No.</th>
                    <th class="center">Código</th>
                    <th class="center">Usuario</th>
                    <th class="center">Fecha</th>
                    <th class="center">Registros</th>
					<th class='text-right'>Acciones</th>
				</tr>

				<?php

				while ($row=mysqli_fetch_array($query)){
						$id_carga=$row['id_carga'];
						$codigo=$row['codigo'];
						$usuario=$row['usuario'];
						$fecha=$row['fecha'];
						$registros=$row['registros'];
					
					?>
					<input type="hidden" value="<?php echo $id_carga;?>" id="id_carga<?php echo $id_carga;?>">
					<input type="hidden" value="<?php echo $codigo;?>" id="codigo<?php echo $id_carga;?>">
					<input type="hidden" value="<?php echo $usuario;?>" id="usuario<?php echo $id_carga;?>">
					<input type="hidden" value="<?php echo $fecha;?>" id="fecha<?php echo $id_carga;?>">
					<input type="hidden" value="<?php echo $registros;?>" id="registros<?php echo $id_carga;?>">
					<tr>
						<td><?php echo $id_carga; ?></td>
						<td><?php echo $codigo; ?></td>
						<td><?php echo $usuario;?></td>
						<td><?php echo $fecha;?></td>
						<td><?php echo $registros;?></td>
					<td ><span class="pull-right">

<?php

					if(0 == 0){

?>
<!--
					<a href="#" class='btn btn-default' title='Editar cliente' onclick="obtener_datos('<?php echo $id_carga;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 
-->
					<a href="#" class='btn btn-default' title='Borrar Carga' onclick="eliminar('<?php echo $id_carga; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>

						
<?php

				}

?>


					</tr>

					<?php

				}

				?>

				<tr>

					<td colspan=7><span class="pull-right">

					<?php

					 echo paginate($reload, $page, $total_pages, $adjacents);

					?></span></td>

				</tr>

			  </table>

			</div>

			<?php

		}

	}

?>