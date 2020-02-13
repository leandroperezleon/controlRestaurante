
		function consultar(page)
		{
			$("#resultados").html("");
			loadRefrest(page)
		}/*consultar*/

		function loadRefrest(page){
			var query=$("#qfd").val();
			var fechaConsulta=$("#qfd").val();			
						
			var per_page=10;
			var parametros = {"action":"ajax","page":page,'query':query,'fechaConsulta':fechaConsulta,'per_page':per_page};
			$("#loader").fadeIn('slow');
			
			$.ajax({
				url:'../ajax/listar_pedidos.php',
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

		$( "#edit_pedido" ).submit(function( event ) {
		var parametros = $(this).serialize();
			$.ajax({
					type: "POST",
					url: "../ajax/editar_pedido.php",
					data: parametros,
					beforeSend: function(objeto){
													$("#resultados").html("Enviando...");
												  },
					success: function(datos){
											$("#resultados").html(datos);
											loadRefrest(1);											
										  }
			});
		  event.preventDefault();
		});	
	
		function mCambiarSeleccion(idpedido){
			
		    var inputNombre = document.getElementById("cant["+idpedido+"]");
		    inputNombre.value = "1";		    
		   
		   /* 
		    var selectOption = document.getElementById("mi_producto["+idpedido+"]");
		    var nomProSeleccionado = document.getElementById("nomProSeleccionado["+idpedido+"]");
		    nomProSeleccionado.value= selectOption.options[selectOption.selectedIndex].text;
		    */	    
			
		}/*mCambiarSeleccion*/