		$(function() {
			load(1);			
		});
		
		function load(page){
			var query=$("#qfd").val();						
			var per_page=10;
			var parametros = {"action":"ajax","page":page,'query':query,'per_page':per_page};
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
		
		function mEstablecerProductoSeleccion(){
			
			$("#edit_pedido").find(':input[name*="idped2"]').each(function() {
				var elemento= this;
		        //alert("elemento.id="+ elemento.id + ", elemento.value=" + elemento.value);  
				var idpedido=elemento.value;
				var selectOption = document.getElementById("mi_producto["+idpedido+"]");
		        
		        
			    var nomProSeleccionado = document.getElementById("nomProSeleccionado["+idpedido+"]");
			    nomProSeleccionado.value= selectOption.options[selectOption.selectedIndex].text;			    
		    });		    
			
		}/*mCambiarSeleccion*/
		