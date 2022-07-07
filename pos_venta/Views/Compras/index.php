<?php include "Views/Templates/header.php"; ?>
	<!--<h1 class="mt-4">Dashboard</h1>-->
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">CATEGORIAS</li>
    </ol>

    <button class="btn btn-primary mb-2" type="submit" onclick="frmCategoria();"><i class="fas fa-plus"></i></button>
		
	<div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            COMPRAR
        </div>
        <div class="card-body">
        	<div class="card">
				<div class="card-header">
				    Producto
				</div>
				  <div class="card-body">
				    <form id="frmCompra">
		        		<div class="row">
		        			<div class="col-md-3">
					            <div class="mb-3">
					            	<input type="hidden" id="id" name="id">
		                        	<label for="codigo" class="form-label"><i class="fas fa-barcode"></i>Codigo de barras</label>
		                        	<input id="codigo" class="form-control" type="text" name="codigo"  placeholder="codigo de barras" onkeyup="buscarCodigo(event)">
		                    	</div> 
					        </div>
					        <div class="col-md-5">
					        	<div class="mb-3">
			                        <label for="descripcion" class="form-label">Descripcion</label>
			                        <input id="descripcion" class="form-control" type="text" name="descripcion"  placeholder="Descripcion del producto" disabled>
			                    </div>
		        			</div>
		                    <div class="col-md-2">
		                    	<div class="mb-3">
		                        	<label for="cantidad" class="form-label">Cantidad</label>
		                        	<input id="cantidad" class="form-control" type="number" name="cantidad"  placeholder="Cantidad" onkeyup="calcularPrecio(event)">
		                    	</div>
		                    </div>
		                    <div class="col-md-2">
		                    	<div class="mb-3">
			                        <label for="precio" class="form-label">Precio</label>
			                        <input id="precio" class="form-control" type="number" name="precio"  placeholder="Precio compra" disabled>
			                    </div>
		                    </div>
		        		</div>
		        		<div class="row">
		        			<div class="col-md-4"></div>
					        <div class="col-md-4"></div>
		                    <div class="col-md-2"></div>
		                    <div class="col-md-2">
		        				<div class="mb-3">
			                        <label for="sub_total" class="form-label">Sub. Total</label>
			                        <input id="sub_total" class="form-control" type="number" name="sub_total"  placeholder="sub total" disabled>
			                    </div>
		                    </div>
		        		</div>
		        	</form>
		        	<div class="row">
	        			<div class="col-md-12">
	        				<label class="form-label">Lista de Compra</label>

	        				<table class="table table-bordered table-hover" style="width:100%" id="">
								<thead class="table-dark">
							    	<th>Id</th>
							    	<th>Descripcion</th>
							    	<th>Cant</th>
							    	<th>Precio</th>
							    	<th>Sub Total</th>
							    	<th></th>
								</thead>
								<tbody id="tblDetalleCompras">
								    
								</tbody>
							</table>
	        			</div>
		        	</div>
		        	<div class="row g-0">
					  	<div class="col-sm-6 col-md-9">
					  		
					  	</div>
					  	<div class="col-6 col-md-3">
					  		<div class="form-group">
		                        <label for="total" class="fw-bold">Total</label>
		                        <input id="total" class="form-control " type="number" name="total"  placeholder="total" disabled>
		                        <div class="d-grid gap-2">
  									<button class="btn btn-primary mt-2" type="button">Generar Compra</button>
								</div>
		                    </div>
					  	</div>
					</div>
				</div>
			</div>
        </div>
	</div>



<?php include "Views/Templates/footer.php"; ?>
