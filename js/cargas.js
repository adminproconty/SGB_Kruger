		$(document).ready(function(){
			
			load(1);
		
		});

		function load(page){
			
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			
			$.ajax({
				url:'./ajax/buscar_cargas.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
					
				}
			})
		}

	
		
			function eliminar (id)
		{
			var q= $("#q").val();
		if (confirm("Realmente deseas eliminar la Carga")){	
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_cargas.php",
        data: "id="+id,"q":q,
		 beforeSend: function(objeto){
			$("#resultados").html('<img src="./img/ajax-loader.gif"> Cargando...');
		  },
        success: function(datos){
		$("#resultados").html(datos);
		setTimeout("location.reload()", 1000);
		load(1);
		}
			});
		}
		}
		
		
	
$( "#guardar_carga" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  event.preventDefault();
 var parametros = $(this);
 var formdata = new FormData(document.getElementById("guardar_carga"));
 var q= $("#codigo").val();
 
	 $.ajax({
			type: "POST",
			url: "ajax/nueva_carga.php",
			dataType: "html",
			data: formdata,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function(objeto){
				$("#resultados_ajax").html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
			success: function(datos){
			$("#resultados_ajax").show("fast");	
			$("#resultados_ajax").html(datos);
			$('#guardar_carga')[0].reset();
			$("#resultados_ajax").hide(1000);
			
			load(1);
		  }
	});
	
  event.preventDefault();
})

$( "#editar_cliente" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_cliente.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax2").html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

	function obtener_datos(id){
			var nombre_cliente = $("#nombre_cliente"+id).val();
			var documento_cliente = $("#documento_cliente"+id).val();
			var estado = $("#estado"+id).val();
			var menu_cliente = $("#menu_cliente"+id).val();
			var a_consumir = $("#a_consumir"+id).val();
			
			
			$("#mod_nombre").val(nombre_cliente);
			$("#mod_id").val(id);
			$("#mod_documento").val(documento_cliente);
			$("#mod_estado").val(estado);
			$("#mod_menu").val(menu_cliente);
			$("#mod_fecha").val(a_consumir);

		
		}
	
		
		

