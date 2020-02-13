<div id="addClienteModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form name="add_cliente" id="add_cliente">
				<div class="modal-header">						
					<h4 class="modal-title">Agregar Cliente</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label>Nombres</label>
						<input type="text" name="nombres"  id="nombres" class="form-control" required>						
					</div>
					<div class="form-group">
						<label>Apellidos</label>
						<input type="text" name="apellidos" id="apellidos" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Identificaci&oacute;n</label>
						<input type="text" name="identificacion" id="identificacion" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Nombre Corto</label>
						<input type="text" name="nombreCorto" id="nombreCorto" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Comentarios</label>
						<textarea id="idComentarios" name="comentarios" id="comentarios" class="form-control"></textarea>
					</div>					
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
					<input type="submit" class="btn btn-success" value="Guardar datos">
				</div>
			</form>
		</div>
	</div>
</div>