<?php include "Views/Templates/header.php"; ?>
	<!--<h1 class="mt-4">Dashboard</h1>-->
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">PRODUCTOS</li>
    </ol>

    <button class="btn btn-primary mb-2" type="submit" onclick="frmProducto();"><i class="fas fa-plus"></i></button>
		
	<div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            PRODUCTOS
        </div>
        <div class="card-body">
        	<div class="table-responsive">
        		<table class="table table-hover" style="width:100%" id="tblProductos">
					<thead class="table-dark">
				    	<th>Id</th>
				    	<th>IMG</th>
				    	<th>Codigo</th>
				    	<th>Descripcion</th>
				    	<th>Precio</th>
				    	<th>Stock</th>
				    	<th>Estado</th>
				    	<th></th>
					</thead>
					<tbody>
					    
					</tbody>
				</table>
        	</div>
        </div>
	</div>


	<div id="nuevo_producto" class="modal" tabindex="-1">
		<div class="modal-dialog">
		    <div class="modal-content">
		    	<form method="post" id="frmProducto">
				    <div class="modal-header bg-primary">
				        <h5 class="modal-title text-white" id="title">Nuevo Producto</h5>
				        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				    </div>
				    <div class="modal-body">
				        <!--<form method="post" id="frmUsuarios">-->
		                <div class="mb-3">
		                	<input type="hidden" id="id" name="id">

		                  	<label for="codigo" class="form-label">Codigo de Barras</label>
		                  	<input id="codigo" type="text" class="form-control" type="text" name="codigo"  placeholder="codigo de barras">
		                </div>
		                <div class="mb-3">
		                  	<label for="descripcion" class="form-label">Descripcion</label>
		                  	<input id="descripcion" type="text" class="form-control" type="text" name="descripcion"  placeholder="descripcion">
		                </div>
		                <div class="row">
			                <div class="col-md-6">
			                    <div class="mb-3">
			                      <label for="precio_compra" class="form-label">Precio Compra</label>
			                      <input id="precio_compra" type="text" class="form-control" name="precio_compra"  placeholder="contraseña">
			                    </div>
			                </div>
			                <div class="col-md-6">
			                	<div class="mb-3">
			                      	<label for="precio_venta" class="form-label">Precio venta</label>
			                      	<input id="precio_venta" type="text" class="form-control" name="precio_venta"  placeholder="precio venta">
			                    </div>
			                </div>
		                </div>

		                <div class="row">
			                <div class="col-md-6">
			                    <div class="mb-3">
			                  		<label for="medida" class="form-label">Medidas</label>
			                  		<select id ="media" name="medida" class="form-select" >

			                    		<option selected>Selecciona una media</option>
			                    		<?php foreach ($data['medidas'] as $row) { ?>
			                      		<option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
			                    
			                    	<?php } ?>
			                    	</select>
			                	</div> 
			                </div>
			                <div class="col-md-6">
			                	<div class="mb-3">
			                  		<label for="categoria" class="form-label">Categorias</label>
			                  		<select id ="categoria" name="categoria" class="form-select" >

			                    		<option selected>Selecciona una categoria</option>
			                    		<?php foreach ($data['categorias'] as $row) { ?>
			                      		<option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
			                    
			                    	<?php } ?>
			                    	</select>
			                	</div> 
			                </div>
		                </div>

		                 <div class="mb-3">
		                  	<label>Foto</label>
		                  	<div class="card boder-primary">
		                  		<div class="card-body">
		                  			<label for="imagen" id="icon-image" class="btn btn-primary"><i class="fas fa-image"></i></label>

		                  			<span id="icon-cerrar"></span>
									<input type="hidden" id="foto_actual" name="foto_actual">
		                  			
		                  			<input id="imagen" class="d-none" type="file" name="imagen" onchange="preview(event)">

		                  			

		                  			<img class="img-thumbnail" id="img-preview">
		                  			
		                  		</div>
		                  	</div>
		                  	
		                </div>

		                  
			            
		                
				    </div>
				    <div class="modal-footer">
				        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
				        <button type="button" class="btn btn-primary" onclick="registarPro(event);" id="btnAccion">Registrar</button>
				    </div>
				</form>
		    </div>
		</div>
	</div>

<?php include "Views/Templates/footer.php"; ?>

