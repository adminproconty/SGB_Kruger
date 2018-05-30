

<section class="content-header">
  <h1>
    <i class="fa fa-file-text-o icon-title"></i> Data de Seguimientos

    <a class="btn btn-primary btn-social pull-right" href="modules/data_seguimientos/print.php" target="_blank">
      <i class="fa fa-print"></i> Imprimir
    </a>
  </h1>

</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-body">
        
          <table id="dataTables1" class="table table-bordered table-striped table-hover">
          
            <thead>
              <tr>
                <th class="center">No.</th>
				<th class="center">Operación</th>
				<th class="center">Acción</th>
				<th class="center">Respuesta</th>
				<th class="center">Contacto</th>
				<th class="center">Teléfono</th>
				<th class="center">Observación</th>
				<th class="center">Valor</th>
				<th class="center">Usuario</th>
				<th class="center">Fecha Gestión</th>
				<th class="center">Fecha Seguimiento</th>
              </tr>
            </thead>
          
            <tbody>
            <?php  
            $no = 1;
          
            $queryges = mysqli_query($mysqli, "SELECT ex.numero_identificacion,ex.numero_operacion,ex.cedente,ex.accion,ex.respuesta,ex.contacto,ex.telefono,ex.observacion,ex.fecha_gestion,ex.valor_compromiso,(select u.username from usuarios u where u.id_user = ex.usuario) as usuario, ex.fecha_gestion as fechag, ex.fecha_seguimiento as fechas FROM gestionextrajudicial ex") 
                                      or die('error: '.mysqli_error($mysqli));

           
            while ($datages = mysqli_fetch_assoc($queryges)) { 
			$valorc = "$ ".number_format($datages[valor_compromiso],2);
			if ($datages[fechas] == '0000-00-00 00:00:00'){
				  $fechas = "";
			  } else {
				  $fechas = $datages[fechas];
			  }
			  echo "<tr>
					  <td width='80' class='center'>$no</td>
					  <td width='30' class='center'>$datages[numero_operacion]</td>
					  <td width='100' class='center'>$datages[accion]</td>
					  <td width='100' class='center'>$datages[respuesta]</td>
					  <td width='30'class='center'>$datages[contacto]</td>
					  <td width='200'align='right'>$datages[telefono]</td>
					  <td width='200'align='right'>$datages[observacion]</td>
					  <td width='200' class='right'>$valorc</td>
					  <td width='200'align='right'>$datages[usuario]</td>
					  <td width='200'align='right'>$datages[fechag]</td>
					  <td width='200'align='right'>$fechas</td>
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