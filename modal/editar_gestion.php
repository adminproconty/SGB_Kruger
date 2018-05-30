<?php
  ?>
<!-- Modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Gestión</h4>
         </div>
         <div class="modal-body">
             <form class="form-horizontal" method="post" id="editar_gestion" name="editar_gestion"> 
            <!-- <form role="form" class="form-horizontal" action="modules/extrajudicial/proses.php?act=update" method="POST" id="editar_gestion"> -->
				   <div id="resultados_ajax2"></div>
				   <div class="form-group">
				   <input type="hidden" class="form-control" id="mod_idgestion" name="mod_idgestion">	
					  <label for="mod_accion" class="col-sm-3 control-label">Acción</label>
					  <div class="col-sm-8">
						 
						 <select class="form-control" id="mod_accion" name="mod_accion" >
							<option value="">-- Selecciona estado --</option>
							<option value="Llamada">Llamada</option>
							<option value="Visita">Visita</option>
							<option value="Investigación">Investigación</option>
						 </select>
					  </div>
				   </div>
				   <div class="form-group">
					  <label for="mod_respuesta" class="col-sm-3 control-label">Respuesta</label>
					  <div class="col-sm-8">
						 <select class="form-control" id="mod_respuesta" name="mod_respuesta" >
							<option value="">-- Selecciona estado --</option>
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
				   </div>
				   <div class="form-group">
					  <label for="mod_contacto" class="col-sm-3 control-label">Contacto</label>
					  <div class="col-sm-8">
						 <input type="text" class="form-control" id="mod_contacto" name="mod_contacto">
					  </div>
				   </div>
				   <div class="form-group">
					  <label for="mod_telefono" class="col-sm-3 control-label">Teléfono</label>
					  <div class="col-sm-8">
						 <input type="text" class="form-control" id="mod_telefono" name="mod_telefono" >
					  </div>
				   </div>
				   <div class="form-group">
					  <label for="mod_valor" class="col-sm-3 control-label">Valor</label>
					  <div class="col-sm-8">
						 <input type="number" class="form-control" id="mod_valor" name="mod_valor" >
					  </div>
				   </div>
				   <div class="form-group">
					  <label for="mod_fechas" class="col-sm-3 control-label">Fecha Seguimiento</label>
					  <div class="col-sm-8">
						 <input type="date" class="form-control" id="mod_fechas" name="mod_fechas" >
					  </div>
				   </div>
				   <div class="form-group">
					  <label for="mod_observacion" class="col-sm-3 control-label">Observación</label>
					  <div class="col-sm-8">
						 <textarea class="form-control" id="mod_observacion" name="mod_observacion" ></textarea>
					  </div>
				   </div>
				 <div class="modal-footer">
					 <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					 <button type="button" class="btn btn-primary submitBtn" onclick="submitContactForm()">Actualizar datos</button>
				 </div>

         </form>
      </div>
   </div>
</div>
<script type="text/javascript" src="js/editar_gestion.js"></script>
<?php
   ?>

