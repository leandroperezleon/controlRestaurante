<div id="editProductoModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form name="edit_producto" id="edit_producto">
				<div class="modal-header">						
					<h4 class="modal-title">Editar producto</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label>C&oacute;digo</label>
						<input type="text" name="edit_code"  id="edit_code" class="form-control" readonly="readonly">
						<input type="hidden" name="edit_id" id="edit_id" >
					</div>
					<div class="form-group">
						<label>Nombres</label>
						<input type="text" name="edit_nombre_producto" id="edit_nombre_producto" class="form-control" readonly="readonly">
					</div>
					<div class="form-group">
						<label>Nombre Corto</label>
						<input type="text" name="edit_nombre_corto_producto" maxlength="9" id="edit_nombre_corto_producto" class="form-control" required>
					</div>				
					<div class="form-group">
						<label>Precio</label>
						<input type="number" name="edit_precio" id="edit_precio" class="form-control" required min="1" max="10" step="0.01">
					</div>					
					<div class="form-group">
						<label>Estado</label>
						<input type="number" name="edit_estado" id="edit_estado" class="form-control" required min="0" max="1">
					</div>			
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
					<input type="submit" class="btn btn-info" value="Guardar datos">
				</div>
			</form>
		</div>
	</div>
</div>