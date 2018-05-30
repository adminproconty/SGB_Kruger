$(document).ready(function(){
	load(1);
});

function load(page){
	var q= $("#q").val();
	$("#loader").fadeIn('slow');
	$.ajax({
		url:'./ajax/buscar_clientes.php?action=ajax&page='+page+'&q='+q,
		 beforeSend: function(objeto){
		 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
	  },
		success:function(data){
			$(".outer_div").html(data).fadeIn('slow');
			$('#loader').html('');
			
		}
	})
}

	
		
function eliminar (id){
		var q= $("#q").val();
		if (confirm("Realmente deseas eliminar el cliente")){	
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_clientes.php",
        data: "id="+id,"q":q,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		load(1);
		}
			});
		}
}
		
		

$("#editar_gestion").submit(function( event ) {
	alert("llega");
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "modules/extrajudicial/proses.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax2").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})


function submitContactForm(){

	var id_gestion = $("#mod_idgestion").val();
	var accion = $('#mod_accion').val();
	var respuesta = $("#mod_respuesta").val();
	var contacto =	$("#mod_contacto").val();
	var telefono = 	$("#mod_telefono").val();
	var observacion = $("#mod_observacion").val();
	var valor =	$("#mod_valor").val();
	var usuario = $("#mod_usuario").val();
	var fechas = $("#mod_fechas").val();
	
	$.ajax({
            type:'POST',
            url:"modules/extrajudicial/proses.php",
            data:'modalGestion=1&id_gestion='+id_gestion+'&accion='+accion+'&respuesta='+respuesta+'&contacto='+contacto+'&telefono='+telefono+'&observacion='+observacion+'&valor='+valor+'&usuario='+usuario+'&fechas='+fechas,
            beforeSend: function () {
                $('.submitBtn').attr("disabled","disabled");
                $('.modal-body').css('opacity', '.5');
            },
            success:function(msg){
				$('.submitBtn').removeAttr("disabled");
                $('.modal-body').css('opacity', '');
				$('#myModal2').modal('hide');
				$("#myModal2").on('hidden.bs.modal', function () {
						window.location.reload(); 
				});
					alert("Gestión Actualizada");
            }
        });
}


function obtener_datos(id){
		
			var id_gestion = id;
			var accion = $("#accion"+id).val();
			var respuesta = $("#respuesta"+id).val();
			var contacto = $("#contacto"+id).val();
			var telefono = $("#telefono"+id).val();
			var observacion = $("#observacion"+id).val();
			var valor = $("#valor"+id).val();
			var usuario = $("#usuario"+id).val();
			var fecha_seguimiento = $("#fechas"+id).val();
			//var fecha_seguimiento = '2017-12-07';
			
			$("#mod_idgestion").val(id_gestion);
			$("#mod_accion").val(accion);
			$("#mod_respuesta").val(respuesta);
			$("#mod_contacto").val(contacto);
			$("#mod_telefono").val(telefono);
			$("#mod_observacion").val(observacion);
			$("#mod_valor").val(valor);
			$("#mod_usuario").val(usuario);
			$("#mod_fechas").val(fecha_seguimiento);
}

