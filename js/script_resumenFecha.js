		$(function() {
			load(1);
		});
		
		function load(page){
			var fechaDesde=$("#qfd").val();
			var fechaHasta=$("#qfh").val();
			var per_page=10;
			var parametros = {"action":"ajax","page":page,'fechaDesde':fechaDesde,'fechaHasta':fechaHasta,'per_page':per_page};
			$("#loader").fadeIn('slow');
			
			$.ajax({
				url:'../ajax/listar_resumenFecha.php',
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