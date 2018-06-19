<?php



	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

	/* Connect To Database*/

	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos

	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos

	

	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

	if (isset($_GET['id'])){

		$id_cliente=intval($_GET['id']);

		$query=mysqli_query($con, "select * from facturas where id_cliente='".$id_cliente."'");

		$count=mysqli_num_rows($query);

		if ($count==0){

			if ($delete1=mysqli_query($con,"DELETE FROM clientes WHERE id_cliente='".$id_cliente."'")){

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

			  <strong>Error!</strong> No se pudo eliminar éste  cliente. Existen facturas vinculadas a éste producto. 

			</div>

			<?php

		}

		

		

		

	}

	if($action == 'ajax'){

		// escaping, additionally removing everything that could be (html/javascript-) code

         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));

		 $aColumns = array('id_carga', 'nombre_cliente','documento_cliente');//Columnas de busqueda

		 $sTable = "clientes cli";

		 $sWhere = "";

		if ( $_GET['q'] != "" )

		{

			$sWhere = "WHERE (";

			for ( $i=0 ; $i<count($aColumns) ; $i++ )

			{

				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";

			}

			$sWhere = substr_replace( $sWhere, "", -3 );

			$sWhere .= ')';

		}

		$sWhere.=" order by id_cliente DESC";

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

		$reload = './clientes.php';

		//main query to fetch the data

		$sql="SELECT cli.*, 
		(select MAX(co.estado) from consumos_diarios co where co.id_cliente = cli.id_cliente and co.estado = 1 ) as estado,
		(select MAX(co.fecha_consumo) from consumos_diarios co where co.id_cliente = cli.id_cliente and co. estado = 1) as fecha_consumo
	   FROM  $sTable $sWhere LIMIT $offset,$per_page";


		$query = mysqli_query($con, $sql);

		//loop through fetched data

		if ($numrows>0){



			?>

			<div class="table-responsive">

			  <table class="table">

				<tr  class="info">

					<th>Id</th>

					<th>Nombre</th>

					<th>Cedula</th>

					<th>Menú</th>

					<th>Fec. a Consumir</th>
					
					<th>Fec.Consumo</th>

					<th>Estado</th>

					<th>IdCarga</th>

					<th class='text-right'>Acciones</th>

					

				</tr>

				<?php

				while ($row=mysqli_fetch_array($query)){

						$id_cliente=$row['id_cliente'];
						$nombre_cliente=$row['nombre_cliente'];
						$documento_cliente=$row['documento_cliente'];
						$estado=$row['estado'];
						$estado_ori=$row['estado'];
						if ($estado==0){$estado="Sin Consumir";$label_class='label-success';}
						else {$estado="Consumido";$label_class='label-danger';}
						$menu_cliente=$row['menu_cliente'];
						$fecha_consumo=$row['fecha_consumo'];
						$a_consumir=$row['fec_consumo'];
						$id_carga=$row['id_carga'];
						
					?>

					

					<input type="hidden" value="<?php echo $id_cliente;?>" id="id_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $nombre_cliente;?>" id="nombre_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $documento_cliente;?>" id="documento_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $estado;?>" id="estado<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $menu_cliente;?>" id="menu_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $fecha_consumo;?>" id="fecha_consumo<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $a_consumir;?>" id="a_consumir<?php echo $id_cliente;?>">

					

					<tr>

						

						<td><?php echo $id_cliente; ?></td>
						<td><?php echo $nombre_cliente; ?></td>
						<td><?php echo $documento_cliente;?></td>
						<td><?php echo $menu_cliente;?></td>
						<td><?php echo $a_consumir;?></td>
						<td><?php echo $fecha_consumo;?></td>
						<td><span class="label <?php echo $label_class;?>"><?php echo $estado; ?></span></td>
						<td><?php echo $id_carga;?></td>
						
						

					<td ><span class="pull-right">

<?php

					if($estado_ori == 0){

?>

					<a href="#" class='btn btn-default' title='Editar cliente' onclick="obtener_datos('<?php echo $id_cliente;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 
<!--
					<a href="#" class='btn btn-default' title='Borrar cliente' onclick="eliminar('<?php echo $id_cliente; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>
-->
						
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