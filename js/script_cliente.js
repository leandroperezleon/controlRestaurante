		$(function() {
			load(1);
		});
		
		function load(page){
			var query=$("#q").val();
			var per_page=10;
			var parametros = {"action":"ajax","page":page,'query':query,'per_page':per_page};
			$("#loader").fadeIn('slow');
			
			$.ajax({
				url:'../ajax/listar_clientes.php',
				data: parametros,
				 beforeSend: function(objeto){
					 							$("#loader").html("Cargando...");
				 							 },
				success:function(data){
										$(".outer_div").html(data).fadeIn('slow');
										$("#loader").html("");
									  }
			})
		}/*load*/		
		
		$('#editClienteModal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var code = button.data('code') 
		  $('#edit_code').val(code)
		  var id = button.data('id') 
		  $('#edit_id').val(id)
		  var nombres = button.data('nombres') 
		  $('#edit_nombres').val(nombres)
		   var apellidos = button.data('apellidos') 
		  $('#edit_apellidos').val(apellidos)		  
		  var identificacion = button.data('identificacion') 
		  $('#edit_identificacion').val(identificacion)		  
		  var nombre_corto = button.data('nombre_corto') 
		  $('#edit_nombre_corto').val(nombre_corto)
		  var estado = button.data('estado') 
		  $('#edit_estado').val(estado)		  
		})
		
		
		$('#deleteClienteModal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var id = button.data('id') 
		  $('#delete_id').val(id)
		})
		
		
		$( "#edit_cliente" ).submit(function( event ) {
		  var parametros = $(this).serialize();
			$.ajax({
					type: "POST",
					url: "../ajax/editar_cliente.php",
					data: parametros,
					 beforeSend: function(objeto){
													$("#resultados").html("Enviando...");
												  },
					success: function(datos){
											$("#resultados").html(datos);
											load(1);
											$('#editClienteModal').modal('hide');
										  }
			});
		  event.preventDefault();
		});
		
		
		$( "#add_cliente" ).submit(function( event ) {
		  var parametros = $(this).serialize();
			$.ajax({
					type: "POST",
					url: "../ajax/guardar_cliente.php",
					data: parametros,
					 beforeSend: function(objeto){
													$("#resultados").html("Enviando...");
												  },
					success: function(datos){
												$("#resultados").html(datos);
												load(1);
												$('#addClienteModal').modal('hide');
										    }
			});
		  event.preventDefault();
		});
		
		$( "#delete_cliente" ).submit(function( event ) {
		  var parametros = $(this).serialize();
			$.ajax({
					type: "POST",
					url: "../ajax/eliminar_cliente.php",
					data: parametros,
					 beforeSend: function(objeto){
						$("#resultados").html("Enviando...");
					  },
					success: function(datos){
					$("#resultados").html(datos);
					load(1);
					$('#deleteClienteModal').modal('hide');
				  }
			});
		  event.preventDefault();
		});