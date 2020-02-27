		$(function() {
			load(1);
			document.getElementById('idFileProducto').addEventListener('change',cargaArchivo,false);
			document.getElementById('idFileProducto_edit').addEventListener('change',updateArchivo,false);
		});
		
		
		function cargaArchivo(ev)
		{	/*	ev.target.files[0].name
				ev.target.files[0].size
				ev.target.files[0].type
			*/			
			
			var imaTipo = ev.target.files[0].type;
			var imaTamanio=ev.target.files[0].size;
			var tiposPermitidos = /(image\/jpg|image\/jpeg|image\/png|image\/gif)$/i;
			var fileProducto = document.getElementById('idFileProducto');
						
			if(!tiposPermitidos.exec(imaTipo))
			{   alert('Extensiones de imagen permitidas jpeg/jpg/png/gif');
		        fileProducto.value = '';
		        return false;
		    }
			else if(imaTamanio/1024 > 300 )
			{   alert('Tamaño del archivo debe ser menor de 300KB');
		        fileProducto.value = '';
		        return false;
		    }
			else
			{   
				if (fileProducto.files && fileProducto.files[0]) 
		        {
		        	var fileReader = new FileReader();
		        	fileReader.onload = function(ev) {
		        		document.getElementById('imagenCargar').src=ev.target.result;		        				        		 
		            };
		            fileReader.readAsDataURL (ev.target.files[0]);
		        }
			}			
		}/*cargaArchivo*/
		
		function updateArchivo(ev)
		{	/*	ev.target.files[0].name
				ev.target.files[0].size
				ev.target.files[0].type
			*/			
			
			var imaTipo = ev.target.files[0].type;
			var imaTamanio=ev.target.files[0].size;
			var tiposPermitidos = /(image\/jpg|image\/jpeg|image\/png|image\/gif)$/i;
			var fileProducto = document.getElementById('idFileProducto_edit');
						
			if(!tiposPermitidos.exec(imaTipo))
			{   alert('Extensiones de imagen permitidas jpeg/jpg/png/gif');
		        fileProducto.value = '';
		        return false;
		    }
			else if(imaTamanio/1024 > 300 )
			{   alert('Tamaño del archivo debe ser menor de 300KB');
		        fileProducto.value = '';
		        return false;
		    }
			else
			{   
				if (fileProducto.files && fileProducto.files[0]) 
		        {
		        	var fileReader = new FileReader();
		        	fileReader.onload = function(ev) {
		        		document.getElementById('edit_imagen_bd').src=ev.target.result;		        		 
		            };
		            fileReader.readAsDataURL (ev.target.files[0]);
		        }
			}			
		}/*cargaArchivo*/

		
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
		  var button = $(event.relatedTarget) // boton que lanzo la modal
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
		  var imagen_bd = button.data('imagen') 
		  $('#edit_imagen_bd').attr("src",imagen_bd);
		})
		
		
		$('#deleteProductoModal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var id = button.data('id') 
		  $('#delete_id').val(id)
		})
		
		
		$( "#edit_producto" ).submit(function( event ) {
			/* Cuando mandamos sólo texto (sin archivos) configuramos estos valores */
	        var lvContentType = 'application/x-www-form-urlencoded';
	        var lvProcessDataLocal = true;	
	        	        
	        /* cuando PHP recibe archivos multiples se acostumbra poner name de <input> con corchetes */
	        if (this['idFileProducto_edit'].files.length) 
	        {	var parametros = new FormData(this);
	            /* cuando recibe file hay que cambiar estos parámetros,
	            en particular contentType=false provoca una cabecera HTTP */
	        	lvContentType = false;
	        	lvProcessData = false;
	        } else {
	        	var parametros = $(this).serialize();
	        }		
	        
			$.ajax({
					type: "POST",
					url: "../ajax/editar_producto.php",
					data: parametros,
					contentType:lvContentType,
					processData:lvProcessData,
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
			
			/* Cuando mandamos sólo texto (sin archivos) configuramos estos valores */
	        var lvContentType = 'application/x-www-form-urlencoded';
	        var lvProcessDataLocal = true;		
			
	        /* cuando PHP recibe archivos multiples se acostumbra poner name de <input> con corchetes */
	        if (this['idFileProducto'].files.length) 
	        {	var parametros = new FormData(this);
                /* cuando recibe file hay que cambiar estos parámetros,
                en particular contentType=false provoca una cabecera HTTP */
	        	lvContentType = false;
	        	lvProcessData = false;
	        } else {
	        	var parametros = $(this).serialize();
	        }
       
			$.ajax({
					type: "POST",
					url: "../ajax/guardar_producto.php",
					data: parametros,
					contentType:lvContentType,
					processData:lvProcessData,
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