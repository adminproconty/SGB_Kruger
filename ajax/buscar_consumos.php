<?php
	date_default_timezone_set('America/Bogota');
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		//obtengo usuario
		$sql_usuario=mysqli_query($con,"select * from users where user_id = ".$_SESSION['user_id']." order by lastname");
            while ($rw=mysqli_fetch_array($sql_usuario)){
				   $user_name=$rw["user_name"];
			}
		$fecha_cambio=date('Y-m-d H:i:s');
		$fecha_hoy=date("Y-m-d");
		$id_cliente=intval($_GET['id']);
		$query=mysqli_query($con, "select * from clientes where id_cliente='".$id_cliente."'");
		$count=mysqli_num_rows($query);
		if ($count>0){
			if ($delete1=mysqli_query($con,"UPDATE consumos_diarios SET `fecha_cambio`= '$fecha_cambio',`estado`= 0,`user_cambio`= '$user_name' WHERE id_cliente='".$id_cliente."'")){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Consumo eliminado exitosamente.
			</div>
			<?php 
			}else {
				?>
				<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Error!</strong> No se pudo eliminar el consumo. Contacte al Administrador.<?php echo($id_cliente) ?>
				</div>
				<?php
			}
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo eliminar éste  consumo. Contacte al Administrador. 
			</div>
			<?php
		}

	}

	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('codigo', 'nombre_cliente','documento_cliente');//Columnas de busqueda
		 $sTable = "clientes";
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

		$sWhere.=" order by nombre_cliente";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$fecha_hoy=date("Y-m-d");
		$count_query   = mysqli_query($con, "SELECT COUNT(*) as numrows FROM  consumos_diarios where date_format(fecha_consumo,'%Y-%m-%d') = '$fecha_hoy' and estado = 1");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './facturas.php';
			   
		
		//main query to fetch the data
		
		$sql="SELECT b.id_cliente, a.nombre_cliente, a.documento_cliente, a.menu_cliente, b.fecha_consumo FROM  consumos_diarios b, clientes a where a.id_cliente = b.id_cliente and date_format(b.fecha_consumo,'%Y-%m-%d') = '$fecha_hoy'  and b.estado = 1 ORDER BY b.fecha_consumo DESC LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>Contador</th>
					<th>Nombre</th>
					<th>Cedula</th>
					<th>Opción</th>
					<th>Fec. Cosumo</th>
					<!--
					<th class='text-right'>Acciones</th>
					-->
				</tr>
				<?php
				$contador = $numrows;
				while ($row=mysqli_fetch_array($query)){
						
						$id_cliente=$row['id_cliente'];
						$nombre_cliente=$row['nombre_cliente'];
						$documento_cliente=$row['documento_cliente'];
						$menu_cliente=$row['menu_cliente'];
						$fec_real_consumo=$row['fecha_consumo'];
					?>
					<input type="hidden" value="<?php echo $nombre_cliente;?>" id="nombre_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $documento_cliente;?>" id="documento_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $menu_cliente;?>" id="menu_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $fec_real_consumo;?>" id="fec_real_consumo<?php echo $id_cliente;?>">
					
					<tr>
						<td><?php echo $contador; ?></td>
						<td><?php echo $nombre_cliente; ?></td>
						<td><?php echo $documento_cliente;?></td>
						<td><?php echo $menu_cliente;?></td>
						<td><?php echo $fec_real_consumo;?></td>
					<!--	
						<td ><span class="pull-right">
						
						<a href="#" class='btn btn-default' title='Borrar cliente' onclick="eliminar('<?php echo $id_cliente; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span>
						
						</td>
					-->	
					</tr>
					<?php
					$contador = $contador -1;
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