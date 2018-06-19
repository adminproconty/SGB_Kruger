	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevaCarga" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nueva Carga</h4>
		  </div>
		  <div class="modal-body">
			
                <?php  
                
                $query_id = mysqli_query($con, "SELECT RIGHT(codigo,6) as codigo FROM cargas
                                                    ORDER BY codigo DESC LIMIT 1")
                                                    or die('error '.mysqli_error($mysqli));

                $count = mysqli_num_rows($query_id);

                if ($count <> 0) {
                
                    $data_id = mysqli_fetch_assoc($query_id);
                    $codigo    = $data_id['codigo'] + 1;
                } else {
                    $codigo = 1;
                }


                $buat_id   = str_pad($codigo, 6, "0", STR_PAD_LEFT);
                $codigo = "C$buat_id";
                ?>
            
            <form class="form-horizontal" method="post" id="guardar_carga" name="guardar_carga">
						
						<!--
						<form action="ajax/nueva_carga.php?act=insert" method='post' enctype="multipart/form-data" class="form-horizontal">
						-->	
							<div id="resultados_ajax"></div>
		  
            

            <div class="form-group">
                <label for="codigo" class="col-sm-3 control-label">Código Carga</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="codigo" id="codigo" value="<?php echo $codigo; ?>" readonly required>
                </div>
              </div>

				<div class="form-group">
                    <label for="archivo" class="col-sm-3 control-label">Seleccionar Archivo</label>
					<div class="col-sm-8">
						   <input required class="form-control" id="archivo" accept=".csv" name="archivo" type="file" /> 
						   <input class="form-control" name="MAX_FILE_SIZE" type="hidden" value="20000" /> 
				
					</div>
				</div>
				
			 
			
		  </div>
		  <div class="modal-footer">
			<button onclick="window.location.reload()" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_datos">Cargar</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>