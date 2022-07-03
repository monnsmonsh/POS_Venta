<?php include "Views/Templates/header.php"; ?>
	<!--<h1 class="mt-4">Dashboard</h1>-->
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Cajas</li>
    </ol>

    <button class="btn btn-primary mb-2" type="submit" onclick="frmCaja();"><i class="fas fa-plus"></i></button>
		
	<div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            CAJAS
        </div>
        <div class="card-body">
        	<table class="table table-hover" style="width:100%" id="tblCajas">
				<thead class="table-dark">
			    	<th>Id</th>
			    	<th>Caja</th>
			    	<th>Estado</th>
			    	<th></th>
				</thead>
				<tbody>
				    
				</tbody>
			</table>
        </div>
	</div>


	<div id="nueva_caja" class="modal" tabindex="-1">
	    <div class="modal-dialog">
	        <div class="modal-content">
	        	<!---form-->
		        <form method="post" id="frmCaja">
		            <div class="modal-header bg-primary">
		                <h5 class="modal-title text-white" id="title">Nueva Caja</h5>
		                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		            </div>
		            <div class="modal-body">
	                    <div class="mb-3">
	                        <label for="caja" class="form-label">Nombre de la caja</label>
	                        <input type="hidden" id="id" name="id">
	                        <input id="caja" type="text" class="form-control" type="text" name="caja"  placeholder="nombre de la caja">
	                    </div>  
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
		                <button type="button" class="btn btn-primary" onclick="registarCaj(event);" id="btnAccion">Registrar</button>
		            </div>
		        </form>
	        </div>
	    </div>
	</div>

<?php include "Views/Templates/footer.php"; ?>
