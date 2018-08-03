<?php
   /* Connect To Database*/
   
   require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
   
   require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
   
   include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
   
   $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
   
   if($action == 'ajax'){
   
   	$aColumns = array('date', 'num_fac', 'document', 'name', 'total');//Columnas de busqueda
   
   	include 'pagination.php'; //include pagination file
   
   	//pagination variables
   
   	$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
   
   	$per_page = 10; //how much records you want to show
   
   	$adjacents  = 4; //gap between pages after number of adjacents
   
   	$offset = ($page - 1) * $per_page;
   
   	//Count the total number of row in your table*/
   
   	
	$count_query   = mysqli_query($con, "
		SELECT COUNT(co.id_consumos) as numrows
		FROM consumos_diarios co
		WHERE co.fecha_consumo >= '".$_GET['inicio']." 00:00:00' 
		AND co.fecha_consumo <= '".$_GET['fin']." 23:59:59'");
	
	$sql="SELECT b.id_cliente as id_cliente, a.nombre_cliente as nombre_cliente, a.documento_cliente as documento_cliente
		, a.menu_cliente as menu_cliente, b.fecha_consumo as fecha_consumo 
			FROM  consumos_diarios b, clientes a 
			where a.id_cliente = b.id_cliente 
			and b.fecha_consumo >= '".$_GET['inicio']." 00:00:00' 
			and b.fecha_consumo <= '".$_GET['fin']." 23:59:59'
			and b.estado = 1
			and b.user_cambio = 'NORMAL'
			UNION
			SELECT co.id_cliente as id_cliente, cod.nombre_maestro as nombre_cliente, cod.codigo_maestro as documento_cliente
			, '' as menu_cliente, co.fecha_consumo as fecha_consumo
			from  codigos_maestros cod, consumos_diarios co 
			where co.id_cliente = cod.id_codigo
			and co.estado = 1
			and co.user_cambio = 'MAESTRO' 
			and co.fecha_consumo >= '".$_GET['inicio']." 00:00:00' 
			and co.fecha_consumo <= '".$_GET['fin']." 23:59:59'
		";
   		
   
   
   	$row= mysqli_fetch_array($count_query);
   	$numrows = $row['numrows'];
   	$total_pages = ceil($numrows/$per_page);
   	$reload = './reportes.php';
   
   	//main query to fetch the data
  
   	$query = mysqli_query($con, $sql);
   ?>
		<input id="cantidad" type='hidden' value="<?php echo $numrows?>">	
		<script>
		var cantidad= $("#cantidad").val();
		if(cantidad > 0){
			localStorage.setItem('exportar', 1);
		}else{
			localStorage.setItem('exportar', 0);
		}
		</script>
	<?php
   //loop through fetched data
   
   if ($numrows>0){
   
   	
   
   	?>
<div class="table-responsive">
   <table class="table" id="Exportar_Clientes">
      <tr  class="info">
	  	 <th>Id</th>
		 <th>Documento Cliente</th>
         <th>Nombre Cliente</th>
         <th>Opción</th>
		 <th>FechaConsumo</th>
         
      </tr>
      <?php
         while ($row=mysqli_fetch_array($query)){
         
				

			//  $fecha= date('d/m/Y', strtotime($row['fecha_factura']));    

			$id_cliente=$row['id_cliente'];
				
			$documento=$row['documento_cliente'];

         		$nombre=$row['nombre_cliente'];
         
         		$menu_cliente=$row['menu_cliente'];
         
				 $fecha_consumo=$row['fecha_consumo'];
         
         	?>
      <tr>
	  	 <td><?php echo $id_cliente; ?></td>
		 <td><?php echo strval($documento); ?></td>
         <td><?php echo $nombre; ?></td>
         <td><?php echo $menu_cliente; ?></td>
		 <td><?php echo $fecha_consumo; ?></td>

      </tr>
      <?php
         }
         
         ?>
      <tr>
         <td colspan=9><span class="pull-right">
            <?php
               //echo paginate($reload, $page, $total_pages, $adjacents);
               
               ?></span>
         </td>
      </tr>
   </table>
   <form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
      <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
      <input type="hidden" id="nombre_reporte" name="nombre_reporte" />
   </form>
</div>
<?php
   }
   
   }
   
   ?>