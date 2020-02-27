<div id="addProductoModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form name="add_producto" id="add_producto" enctype="multipart/form-data">
				<div class="modal-header">						
					<h4 class="modal-title">Agregar producto</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label>Nombre Producto</label>
						<input type="text" name="nombreProducto"  id="nombreProducto" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Nombre Corto Producto</label>
						<input type="text" name="nombreCortoProducto" id="nombreCortoProducto" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Imagen Producto</label>						
						<input type="file" name="idFileProducto" id="idFileProducto" accept="image/*" required>	<br>
						<img id="imagenCargar" class="img-thumbnail"></img>
					</div>
					<div class="form-group">
						<label>Precio</label>
						<input type="number" name="precio" id="precio" class="form-control" required min="1" max="10" step="0.01">
					</div>										
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-secondary" data-dismiss="modal" value="Cancelar">
					<input type="submit" class="btn btn-secondary" value="Guardar datos">
				</div>
			</form>
		</div>
	</div>
</div>