		$(function() {
			load(1);
		});
		
		function load(page){
			var query=$("#q").val();
			var per_page=10;
			var parametros = {"action":"ajax","page":page,'query':query,'per_page':per_page};
			$("#loader").fadeIn('slow');
			
			$.ajax({
				url:'../ajax/listar_productos.php',
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
		
		$('#editProductoModal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var code = button.data('code') 
		  $('#edit_code').val(code)
		  var id = button.data('id') 
		  $('#edit_id').val(id)
		  var nombre_producto = button.data('nombre_producto') 
		  $('#edit_nombre_producto').val(nombre_producto)
		  var nombre_corto_producto = button.data('nombre_corto_producto') 
		  $('#edit_nombre_corto_producto').val(nombre_corto_producto)
		  var precio = button.data('precio') 
		  $('#edit_precio').val(precio)	
		  var estado = button.data('estado') 
		  $('#edit_estado').val(estado)		  
		})
		
		
		$('#deleteProductoModal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var id = button.data('id') 
		  $('#delete_id').val(id)
		})
		
		
		$( "#edit_producto" ).submit(function( event ) {
		  var parametros = $(this).serialize();
			$.ajax({
					type: "POST",
					url: "../ajax/editar_producto.php",
					data: parametros,
					 beforeSend: function(objeto){
													$("#resultados").html("Enviando...");
												  },
					success: function(datos){
											$("#resultados").html(datos);
											load(1);
											$('#editProductoModal').modal('hide');
										  }
			});
		  event.preventDefault();
		});
		
		
		$( "#add_producto" ).submit(function( event ) {
		  var parametros = $(this).serialize();
			$.ajax({
					type: "POST",
					url: "../ajax/guardar_producto.php",
					data: parametros,
					 beforeSend: function(objeto){
													$("#resultados").html("Enviando...");
												  },
					success: function(datos){
												$("#resultados").html(datos);
												load(1);
												$('#addProductoModal').modal('hide');
										    }
			});
		  event.preventDefault();
		});
		
		$( "#delete_producto" ).submit(function( event ) {
		  var parametros = $(this).serialize();
			$.ajax({
					type: "POST",
					url: "../ajax/eliminar_producto.php",
					data: parametros,
					 beforeSend: function(objeto){
						$("#resultados").html("Enviando...");
					  },
					success: function(datos){
					$("#resultados").html(datos);
					load(1);
					$('#deleteProductoModal').modal('hide');
				  }
			});
		  event.preventDefault();
		});