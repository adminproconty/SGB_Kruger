<section class="content-header">
  <h1>
    <i class="fa fa-users icon-title"></i> Listado de Clientes
<!--
    <a class="btn btn-primary btn-social pull-right" href="?module=form_extrajudicial&form=add" title="agregar" data-toggle="tooltip">
      <i class="fa fa-plus"></i> Agregar
    </a>
-->
  </h1>

</section>


<section class="content">
  <div class="row">
    <div class="col-md-12">

    <?php  

    if (empty($_GET['alert'])) {
      echo "";
    } 
  
    elseif ($_GET['alert'] == 1) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Exito!</h4>
             Nuevos datos de gestión han sido almacenados correctamente.
            </div>";
    }

    elseif ($_GET['alert'] == 2) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Exito!</h4>
             Datos del Medicamento modificados correcamente.
            </div>";
    }

    elseif ($_GET['alert'] == 3) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Exito!</h4>
            Se eliminaron los datos del Medicamento
            </div>";
    }
    ?>

      <div class="box box-primary">
        <div class="box-body">
    
          <table id="dataTables2" class="table table-bordered table-striped table-hover" >
      
            <thead>
              <tr>
                <th class="center">No.</th>
                <th class="center">Identificación</th>
                <th class="center">Nombre Cliente</th>
                <th class="center">Monto Deuda</th>
				<th class="center">Usuario Asignado</th>
                <th class="center">Fecha Gestión</th>
				<th class="center">Fecha Seguimiento</th>
				<th class="center">Estado</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            <?php  
            $no = 1;
			$usuariog = intval($_SESSION['id_user']);
			$fecha_actual=date('Y-m-d');
			//$usuariog = 7;
            if ($usuariog==1) { 
				$query = mysqli_query($mysqli, "SELECT de.iddeudores as id_deudores,(select u.username from usuarios u where u.id_user = de.user_registro) as usuario_asignado, de.numero_identificacion as identificacion, de.nombre_completo as nombre, de.agencia as agencia, (select pr.descripcion from provincias pr where pr.codigo = de.provincia) as provincia, cr.monto_deuda, cr.monto_deuda, (SELECT g.fecha_gestion FROM gestionextrajudicial g where g.numero_identificacion = de.numero_identificacion order by g.idgestionextrajudicial DESC LIMIT 1) as fechag, (SELECT g.fecha_seguimiento FROM gestionextrajudicial g where g.numero_identificacion = de.numero_identificacion order by g.idgestionextrajudicial DESC LIMIT 1) as fechas, de.estado as estado
												FROM deudores de, creditos cr
												WHERE de.numero_identificacion = cr.numero_identificacion
												AND de.actual = 'SI' ORDER BY de.numero_identificacion DESC")
												or die('error: '.mysqli_error($mysqli));
			} else {
				$query = mysqli_query($mysqli, "SELECT de.iddeudores as id_deudores,(select u.username from usuarios u where u.id_user = de.user_registro) as usuario_asignado, de.numero_identificacion as identificacion, de.nombre_completo as nombre, de.agencia as agencia, (select pr.descripcion from provincias pr where pr.codigo = de.provincia) as provincia, cr.monto_deuda, cr.monto_deuda, (SELECT g.fecha_gestion FROM gestionextrajudicial g where g.numero_identificacion = de.numero_identificacion order by g.idgestionextrajudicial DESC LIMIT 1) as fechag, (SELECT g.fecha_seguimiento FROM gestionextrajudicial g where g.numero_identificacion = de.numero_identificacion order by g.idgestionextrajudicial DESC LIMIT 1) as fechas, de.estado as estado
											FROM deudores de, creditos cr
											WHERE de.numero_identificacion = cr.numero_identificacion and de.user_registro = $usuariog
											AND de.actual = 'SI' ORDER BY de.numero_identificacion DESC")
                                            or die('error: '.mysqli_error($mysqli));
			}
            while ($data = mysqli_fetch_assoc($query)) { 
			  
              $monto1 = "$ ".number_format($data[monto_deuda],2);
              $precio_venta = format_rupiah($data['precio_venta']);
			  
			  
			  if ($data[fechas] == '0000-00-00 00:00:00'){
				  $fechas = "";
			  } else {
				  $fechas = $data[fechas];
			  }
              
			  $fechag = '';
			  if ($data[fechag] != '') {
				$date = date_create($data[fechag]);
				$fechag=date_format($date, 'Y-m-d');
			  }
			  
				if ($data[estado] == ''){
				  if ($fecha_actual == $fechag){
					   $estado_gestion = '<span class="label label-success">Gestionado Hoy</span>'; 
				  } else {
					  $estado_gestion = ''; 
				  }
				}  else {
					if ($data[estado] == 'Finalizado'){
						$estado_gestion = '<span class="label label-danger">'.$data[estado].'</span>';  
					} 
					if ($data[estado] == 'Seguimiento'){
						$estado_gestion = '<span class="label label-warning">'.$data[estado].'</span>';  
					}
					
				}
              echo "<tr>
                      <td width='30' class='center'>$no</td>
                      <td width='80' class='center'>$data[identificacion]</td>
                      <td width='250'>$data[nombre]</td>
					  <td width='10'align='right'>$monto1</td>
					  <td width='10'align='right'>$data[usuario_asignado]</td>
					  <td width='10'align='right'>$data[fechag]</td>
					  <td width='10'align='right'>$fechas</td>
					  <td width='15' class='center'>$estado_gestion</td>
					  <td class='center' width='80'>
						<div>
                          <a data-toggle='tooltip' data-placement='top' title='Gestionar' style='margin-right:5px' class='btn btn-primary btn-sm' href='?module=form_extrajudicial&form=edit&id=$data[identificacion]'>
                              <i style='color:#fff' class='glyphicon glyphicon-edit'></i>
                          </a>";
            ?>
                        <!--  <a data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-danger btn-sm" href="modules/extrajudicial/proses.php?act=delete&id=<?php echo $data['codigo'];?>" onclick="return confirm('estas seguro de eliminar<?php echo $data['nombre']; ?> ?');">
                              <i style="color:#fff" class="glyphicon glyphicon-trash"></i>
                          </a>
						-->  
            <?php
              echo "    </div>
                      </td>
                    </tr>";
              $no++;
            }
            ?>
            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!--/.col -->
  </div>   <!-- /.row -->
  
</section><!-- /.content