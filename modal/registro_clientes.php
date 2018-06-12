	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo cliente</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_cliente" name="guardar_cliente">
			<div id="resultados_ajax"></div>
			  
			  <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="nombre" name="nombre" required>
				</div>
			  </div>
			  <div class="form-group">
				<label for="documento_cliente" class="col-sm-3 control-label">Cédula</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="documento_cliente" name="documento_cliente" required>
				</div>
			  </div>


				<div class="form-group">
				<label for="menu_cliente" class="col-sm-3 control-label">Opción</label>
					<div class="col-sm-8">
					<select class="form-control" id="menu_cliente" name="menu_cliente" required>
						<option value="" selected>-- Selecciona opción --</option>
						<option value="Opcion1">Opción1</option>
						<option value="Opcion2">Opción2</option>
						<option value="Dieta">Dieta</option>
						<option value="Vegetariano">Vegetariano</option>

						</select>
					</div>
					</div>	

				<div class="form-group">			  
			  <label for="fecha_consumo" class="col-sm-3 control-label">Fecha a Consumir</label>
				<div class="col-sm-8">
				  <input type="date" class="form-control" id="fecha_consumo" name="fecha_consumo" required>
				</div>
			  </div>
				
			 
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>