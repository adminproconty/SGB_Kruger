	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar cliente</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_cliente" name="editar_cliente">
			<div id="resultados_ajax2"></div>
			  
			  <div class="form-group">
				<label for="mod_nombre" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_nombre" name="mod_nombre"  required>
					<input type="hidden" name="mod_id" id="mod_id">
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_documento" class="col-sm-3 control-label">Cédula</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_documento" name="mod_documento" required>
				</div>
			  </div>
			  

				<div class="form-group">
				<label for="mod_menu" class="col-sm-3 control-label">Opción</label>
					<div class="col-sm-8">
					<select class="form-control" id="mod_menu" name="mod_menu" required>
						<option value="">-- Selecciona opción --</option>
						<option value="Opcion1" selected>Opción1</option>
						<option value="Opcion2" selected>Opción2</option>
						<option value="Dieta" selected>Dieta</option>
						<option value="Vegetariano" selected>Vegetariano</option>

						</select>
					</div>
					</div>	

				<div class="form-group">
				<label for="mod_fecha" class="col-sm-3 control-label">Fecha a Consumir</label>
				<div class="col-sm-8">
				 <input type="date" class="form-control" id="mod_fecha" name="mod_fecha" required>
				</div>
			  </div>

			  
			  
			  
			 
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_datos">Actualizar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>