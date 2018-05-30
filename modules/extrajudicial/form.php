 <?php  

if ($_GET['form']=='add') { ?> 

  <!-- NO SE ESTA USANDO LA OPCION DE ADD -->
<?php
}

elseif ($_GET['form']=='edit') { 
  if (isset($_GET['id'])) {

      $query = mysqli_query($mysqli, "SELECT e.iddeudores, e.tipo_documento,e.numero_identificacion,e.nombre_completo,e.apellidos,e.nombres,e.agencia,e.plaza,(select p.descripcion from provincias p where p.codigo = e.provincia) as provincia,e.sexo,(select s.descripcion from estado_civil s where s.codigo = e.estado_civil) as estado_civil,e.profesion,e.actividad_economica,e.fecha_registro,e.user_registro,e.actual, e.estado FROM deudores e WHERE e.numero_identificacion='$_GET[id]'") 
                                      or die('error: '.mysqli_error($mysqli));
      $data  = mysqli_fetch_assoc($query);
	  
	  $querydir = mysqli_query($mysqli, "SELECT tipo_documento,numero_identificacion,direccion,tipo_direccion,provincia,ciudad,d.fecha_registro,d.user_registro,d.actual FROM direcciones d WHERE d.numero_identificacion='$_GET[id]'") 
                                      or die('error: '.mysqli_error($mysqli));
      $datadir  = mysqli_fetch_assoc($querydir);
	  
	  $querytel = mysqli_query($mysqli, "SELECT t.numero_telefono, t.tipo_telefono
											FROM telefonos t
											WHERE t.numero_identificacion = '$_GET[id]'
											ORDER BY t.tipo_telefono DESC")
                                            or die('error: '.mysqli_error($mysqli));
	  //$datatel  = mysqli_fetch_assoc($querytel);		

	 $querycred = mysqli_query($mysqli, "SELECT cr.tipo_documento,cr.numero_identificacion,cr.numero_operacion,cr.monto_deuda,cr.cuota_mas_vencido,cr.cuotas_vencidas,cr.tasa_credito,cr.fecha_creacion,cr.tipo_credito,cr.fecha_vencimiento,cr.estado_operacion,cr.total_pagar,cr.descripcion,cr.nombre_agencia,cr.plazo,cr.fecha_registro,cr.user_registro,cr.actual FROM creditos cr WHERE cr.numero_identificacion='$_GET[id]'") 
                                      or die('error: '.mysqli_error($mysqli));
									  
	 $queryges = mysqli_query($mysqli, "SELECT ex.idgestionextrajudicial, ex.numero_identificacion,ex.numero_operacion,ex.cedente,ex.accion,ex.respuesta,ex.contacto,ex.telefono,ex.observacion,ex.fecha_gestion,ex.valor_compromiso,(select u.username from usuarios u where u.id_user = ex.usuario) as usuario, ex.fecha_seguimiento FROM gestionextrajudicial ex WHERE ex.numero_identificacion='$_GET[id]'") 
                                      or die('error: '.mysqli_error($mysqli));

	$querypagos = mysqli_query($mysqli, "SELECT * from pagos pa WHERE pa.numero_identificacion='$_GET[id]'") 
                                      or die('error: '.mysqli_error($mysqli));
									  
	$queryreferencias = mysqli_query($mysqli, "SELECT * from referencias re WHERE re.numero_identificacion='$_GET[id]'") 
                                      or die('error: '.mysqli_error($mysqli));								  
								  
									  
    }
?>

  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Ingresar Gestión
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=start"><i class="fa fa-home"></i> Inicio </a></li>
      <li><a href="?module=extrajudicial"> Gestión Extra Judicial </a></li>
      <li class="active"> Ingresar Gestión </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" action="modules/extrajudicial/proses.php?act=insert" method="POST" name="xxx">
            <div class="box-body">
			  <font color="#24AAFF">	
              <h4><strong> Datos Cliente </strong></h4>
			  </font>
              <div class="form-group">
                
					<div class="col-sm-2">
					  <label>Identificación</label>
					  <input type="hidden" class="form-control" name="id_deudores" value="<?php echo $data['iddeudores']; ?>" readonly required>
					  <input type="text" class="form-control" name="numero_identificacion" value="<?php echo $data['numero_identificacion']; ?>" readonly required>
					</div>
					<div class="col-sm-4">
					  <label>Nombre</label>
					  <input type="text" class="form-control" name="nombre_completo" autocomplete="off" value="<?php echo $data['nombre_completo']; ?>" readonly required>
					</div>
					<div class="col-sm-2">
					  <label>Estado Civil</label>
					  <input type="text" class="form-control" name="estado_civil" autocomplete="off" value="<?php echo $data['estado_civil']; ?>" readonly required>
					</div>
					<div class="col-sm-2">
					  <label>Provincia</label>
					  <input type="text" class="form-control" name="provincia" autocomplete="off" value="<?php echo $data['provincia']; ?>" readonly required>
					</div>
					<div class="col-sm-2">
					  <label>Agencia</label>
					  <input type="text" class="form-control" name="agencia" autocomplete="off" value="<?php echo $data['agencia']; ?>" readonly required>
					</div>
              </div>

			  
			  <div class="form-group">
                
					<div class="col-sm-6">
					  <label>Dirección</label>
					  <input type="text" class="form-control" name="direccion" autocomplete="off" value="<?php echo $datadir['direccion']; ?>" readonly required>
					</div>
					<div class="col-sm-2">
					  <label>Tipo Dirección</label>
					  <input type="text" class="form-control" name="tipo_direccion" value="<?php switch ($datadir['tipo_direccion']) {
																							case 'D':
																								echo "Domicilio";
																								break;
																							case 'L':
																								echo "Laboral";
																								break;
																							case 'R':
																								echo "Referencia";
																								break;
																						} ?>" readonly required>
					</div>


					<div class="col-sm-6">
						<h5></h5>
						<label>Teléfonos de Contacto</label>
						<TABLE class="table table-hover">
							<?php
										echo "<TR>
												<TD  ALIGN='CENTER'>- Tipo -</TD>
												<TD  ALIGN='CENTER'>- Teléfono -</TH>
										  </TR>";
								while ($datatel = mysqli_fetch_assoc($querytel)) { 
									$numero_telefono = 	$datatel['numero_telefono'];
									
									$tipo_telefono = str_replace("C", "Celular", $datatel['tipo_telefono']);
									
									
									
									
									echo "<TR>";
									echo "<TD  ALIGN='CENTER'>$tipo_telefono</TD><TD  ALIGN='CENTER'>$numero_telefono</TD>";
									echo "</TR>";
								}	
							?>		  
						</TABLE>
					</div>	
				</div>
				
				<font color="#24AAFF">	
              <h4><strong> Referencias </strong></h4>
			  </font>
				<div class="form-group">
					<table id="dataTables3" class="table table-bordered table-striped table-hover" width="100%">
					   <thead>
						  <tr>
							<th class="center">No.</th>
							<th class="center">Identificación</th>
							<th class="center">Nombre</th>
							<th class="center">Teléfono</th>
							<th></th>
						  </tr>
						</thead>
					 <tbody>
					<?php  
						$no = 1;
						while ($dataref = mysqli_fetch_assoc($queryreferencias)) { 
						  echo "<tr>
								  <td width='80' class='center'>$no</td>
								  <td width='30' class='center'>$dataref[numero_identificacion_ref]</td>
								  <td width='300'align='right'>$dataref[nombre]</td>
								  <td width='200'align='right'>$dataref[telefono]</td>
								</tr>";
						  $no++;
						}
					?>
					 </tbody>
					</table> 
				</div>
				
				<font color="#24AAFF">	
              <h4><strong> Datos del Crédito </strong></h4>
			  </font>
				<div class="form-group">
					<table id="dataTables3" class="table table-bordered table-striped table-hover" width="100%">
					   <thead>
						  <tr>
							<th class="center">No.</th>
							<th class="center">Operación</th>
							<th class="center">Monto Deuda</th>
							<th class="center">Cuotas Más Vencidas</th>
							<th class="center">Cuotas Vencidas</th>
							<th class="center">Tasa Crédito</th>
							<th class="center">Fecha Creación</th>
							<th class="center">Fecha Vencimiento</th>
							<th class="center">Total a Pagar</th>

							<th></th>
						  </tr>
						</thead>

					 <tbody>
					<?php  
						$no = 1;
						$combobit = '';
						while ($datacred = mysqli_fetch_assoc($querycred)) { 
						    $combobit .=" <option value=$datacred[numero_operacion]>$datacred[numero_operacion]</option>"; 
							$monto1 = "$ ".number_format($datacred[monto_deuda],2);
							$total1 = "$ ".number_format($datacred[total_pagar],2);
						  echo "<tr>
								  <td width='80' class='center'>$no</td>
								  <td width='30' class='center'>$datacred[numero_operacion]</td>
								  <td width='200' class='right'>$monto1</td>
								  <td width='100' class='center'>$datacred[cuota_mas_vencido]</td>
								  <td width='100' class='center'>$datacred[cuotas_vencidas]</td>
								  <td width='30'class='center'>$datacred[tasa_credito]</td>
								  <td width='200'align='right'>$datacred[fecha_creacion]</td>
								  <td width='200'align='right'>$datacred[fecha_vencimiento]</td>
								  <td width='200'align='right'>$total1</td>
								</tr>";
						  $no++;
						}
						?>
					 </tbody>
					</table> 
				</div>

				<font color="#24AAFF">	
              <h4><strong> Pagos Realizados </strong></h4>
			  </font>
				<div class="form-group">
					<table id="dataTables3" class="table table-bordered table-striped table-hover" width="100%">
					   <thead>
						  <tr>
							<th class="center">No.</th>
							<th class="center">Operación</th>
							<th class="center">Fecha Pago</th>
							<th class="center">Valor Pago</th>
							<th></th>
						  </tr>
						</thead>
					 <tbody>
					<?php  
						$no = 1;
						while ($dataope = mysqli_fetch_assoc($querypagos)) { 
						  echo "<tr>
								  <td width='80' class='center'>$no</td>
								  <td width='30' class='center'>$dataope[numero_operacion]</td>
								  <td width='200'align='right'>$dataope[fecha_pago]</td>
								  <td width='200'align='right'>$dataope[valor_pago]</td>
								</tr>";
						  $no++;
						}
					?>
					 </tbody>
					</table> 
				</div>	
				
				
					
			  <font color="#24AAFF">	
              <h4><strong> Estado del Cliente </strong></h4>
			  </font>
				<div class="form-group">
					<div class="col-sm-3">
					  <label>Estado</label>
					  <select class="chosen-select" name="estado" data-placeholder="-- Seleccionar --" autocomplete="off">
						<option value="<?php echo $data['estado']; ?>" selected><?php echo $data['estado']; ?></option>
						<option value="Finalizado">Finalizado</option>
						<option value="Seguimiento">Seguimiento</option>
						<option value="">Ninguno</option>
					  </select>
					</div>
				</div>
					  
				<font color="#24AAFF">	
              <h4><strong> Datos de la Gestión </strong></h4>
			  </font>
				<div class="form-group">
					<div class="col-sm-2">
					  <label>Operación</label>
					  <select class="chosen-select" name="numero_operacion" data-placeholder="-- Seleccionar --" autocomplete="off" required>
							<?php echo $combobit; ?>
					  </select>
					</div>
					
					<div class="col-sm-3">
					  <label>Acción</label>
					  <select class="chosen-select" name="accion" data-placeholder="-- Seleccionar --" autocomplete="off">
						<option value=""></option>
						<option value="Llamada">Llamada</option>
						<option value="Visita">Visita</option>
						<option value="Investigación">Investigación</option>
					  </select>
					</div>

					<div class="col-sm-3">
					  <label>Respuesta</label>
					  <select class="chosen-select" name="respuesta" data-placeholder="-- Seleccionar --" autocomplete="off">
						<option value=""></option>
						<option value="Posterga Solucion">Posterga Solución</option>
						<option value="No Contesta">No Contesta</option>
						<option value="Ubicado">Ubicado</option>
						<option value="No Localizado">No Localizado</option>
						<option value="Mensaje a Terceros">Mensaje a Terceros</option>
						<option value="Compromiso de Pago">Compromiso de Pago</option>
						<option value="Equivocado">Equivocado</option>
						<option value="Fallecido">Fallecido</option>
						<option value="Detenido">Detenido</option>
					  </select>
					</div>
					
					<div class="col-sm-3">
						  <label>Contacto</label>
						  <input type="text" class="form-control" name="contacto" autocomplete="off">
						
					</div>
					<div class="col-sm-2">
						  <label>Teléfono</label>
						  <input type="text" class="form-control" name="telefono" autocomplete="off">

					</div>
					<div class="col-sm-2">
						  <label>Valor</label>
						  <input type="number" class="form-control" name="valor" autocomplete="off" step="any">

					</div>
					<div class="col-sm-2">
						  <label>Fecha Seguimiento</label>
						  <input type="date" class="form-control" name="fechas" autocomplete="off" step="any">

					</div>
					
					
					<div class="col-sm-2" spellcheck="true">
						  <label>Observación (*)</label>
						  
						<textarea name="observacion" rows="3" cols="42" required></textarea>
					</div>
					
					
					
					<div class="col-sm-2">
						  <label></label>
						  <input type="hidden" class="form-control" name="usuario" autocomplete="off" value="<?php echo $codigo; ?>" readonly required>

					</div>
				
					
				</div>
            </div><!-- /.box body -->

            <div class="box-footer">
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" class="btn btn-primary btn-submit" name="Guardar" value="Guardar">
                  <a href="?module=extrajudicial" class="btn btn-default btn-reset">Cancelar</a>
                </div>
              </div>
            </div><!-- /.box footer -->
          
		  <div class="box-body">
		  <font color="#24AAFF">	
              <h4><strong> Historial de Gestiones </strong></h4>
			  </font>
		  <table id="dataTables4" class="table table-bordered table-striped table-hover" width="100%">
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
							<th class="center">Fecha Seguimiento</th>

							<th></th>
						  </tr>
						</thead>

					 <tbody>
					 <?php  
						include("modal/editar_gestion.php");
						$no = 1;
						while ($datages = mysqli_fetch_assoc($queryges)) { 
						
							$id_gestion = $datages['idgestionextrajudicial'];
							$numero_operacion = $datages['numero_operacion'];
							$accion = $datages['accion'];
							$respuesta = $datages['respuesta'];
							$contacto = $datages['contacto'];
							$telefono = $datages['telefono'];
							$observacion = $datages['observacion'];
							$usuario = $datages['usuario'];
							$valorc = "$ ".number_format($datages['valor_compromiso'],2);
							$valor = $datages['valor_compromiso'];
							$fecha_seguimiento = $datages['fecha_seguimiento'];
							$date = date_create($fecha_seguimiento);
							$fechas=date_format($date, 'Y-m-d');

							?>

								<input type="hidden" value="<?php echo $id_gestion;?>" id="id_gestion<?php echo $id_gestion;?>">
								<input type="hidden" value="<?php echo $accion;?>" id="accion<?php echo $id_gestion;?>">
								<input type="hidden" value="<?php echo $respuesta;?>" id="respuesta<?php echo $id_gestion;?>">
								<input type="hidden" value="<?php echo $contacto;?>" id="contacto<?php echo $id_gestion;?>">
								<input type="hidden" value="<?php echo $telefono;?>" id="telefono<?php echo $id_gestion;?>">
								<input type="hidden" value="<?php echo $observacion;?>" id="observacion<?php echo $id_gestion;?>">
								<input type="hidden" value="<?php echo $valor;?>" id="valor<?php echo $id_gestion;?>">
								<input type="hidden" value="<?php echo $usuario;?>" id="usuario<?php echo $id_gestion;?>">
								<input type="hidden" value="<?php echo $fechas;?>" id="fechas<?php echo $id_gestion;?>">
								
							

							<tr>
								
								<td><?php echo $no; ?></td>
								<td><?php echo $numero_operacion; ?></td>
								<td><?php echo $accion; ?></td>
								<td><?php echo $respuesta; ?></td>
								<td><?php echo $contacto; ?></td>
								<td><?php echo $telefono; ?></td>
								<td><?php echo $observacion; ?></td>
								<td ><?php echo $valorc; ?></td>
								<td><?php echo $usuario; ?></td>
								<td><?php echo $fecha_seguimiento; ?></td>
							
								 <td ><span class="pull-right">
										<a href="#" class='btn btn-default' title='Editar Gestión' onclick="obtener_datos('<?php echo $id_gestion;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 
							</tr>
							<?php

							  $no++;
						}
						?>
					  
					 </tbody>
					</table> 
				</div>
		  
		  </form>
        </div><!-- /.box -->
      </div><!--/.col -->
    </div>   <!-- /.row -->
	

  </section><!-- /.content -->
<?php
}
?>