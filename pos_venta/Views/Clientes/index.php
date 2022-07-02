<?php include "Views/Templates/header.php"; ?>
	<!--<h1 class="mt-4">Dashboard</h1>-->
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Clientes</li>
    </ol>

    <button class="btn btn-primary mb-2" type="submit" onclick="frmCliente();"><i class="fas fa-plus"></i></button>
		
	<div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Clientes
        </div>
        <div class="card-body">
        	<table class="table table-hover" style="width:100%" id="tblClientes">
				<thead class="table-dark">
			    	<th>Id</th>
			    	<th>DNI</th>
			    	<th>Nombre</th>
			    	<th>Telefono</th>
			    	<th>Direccion</th>
			    	<th>Estado</th>
			    	<th></th>
				</thead>
				<tbody>
				    
				</tbody>
			</table>
        </div>
	</div>


	<div id="nuevo_cliente" class="modal" tabindex="-1">
	    <div class="modal-dialog">
	        <div class="modal-content">
		        <form method="post" id="frmCliente">
		            <div class="modal-header bg-primary">
		                <h5 class="modal-title text-white" id="title">Nuevo Cliente</h5>
		                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		            </div>
		            <div class="modal-body">
	                    <div class="mb-3">
	                        <label for="dni" class="form-label">DNI</label>
	                        <input type="hidden" id="id" name="id">
	                        <input id="dni" type="text" class="form-control" type="text" name="dni"  placeholder="dni">
	                    </div>
	                    <div class="mb-3">
	                        <label for="nombre" class="form-label">Nombre</label>
	                        <input id="nombre" type="text" class="form-control" type="text" name="nombre"  placeholder="nombre del cliente">
	                    </div>      
	                    <div class="mb-3">
	                        <label for="telefono" class="form-label">Telefono</label>
	                        <input id="telefono" type="text" class="form-control" type="text" name="telefono"  placeholder="telefono">
	                    </div> 
	                    <div class="mb-3">
	                        <label for="direccion" class="form-label">Direccion</label>
	                        <input id="direccion" type="text" class="form-control" type="text" name="direccion"  placeholder="direccion">
	                    </div> 
		                  
		                    
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
		                <button type="button" class="btn btn-primary" onclick="registarCli(event);" id="btnAccion">Registrar</button>
		            </div>
		        </form>
	        </div>
	    </div>
	</div>

<?php include "Views/Templates/footer.php"; ?>

