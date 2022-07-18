<?php include "Views/Templates/header.php"; ?>
	<!--<h1 class="mt-4">Dashboard</h1>-->

		
	<div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Datos de la empresa
        </div>
        <div class="card-body">
        	<!---form-->
	        <form id="frmEmpresa">
	            <div class="modal-header bg-dark">
	                <h5 class="modal-title text-white" id="title">Datos</h5>
	            </div>
	            <div class="modal-body">
	            	<input type="hidden" id="id" name="id" value="<?php echo $data['id']?>">


	            		<div class="row">
	            			<div class="col-md-6">
	            			<div class="mb-3">
		                        <label for="ruc" class="form-label">RUC</label>
		                        <input id="ruc" type="text" class="form-control" name="ruc"  placeholder="RUC de la empresa" value="<?php echo $data['ruc']?>">
		                    </div>
	            		</div>
	            		<div class="col-md-6">
	            			<div class="mb-3">
		                        <label for="nombre" class="form-label">Nombre de la empresa</label>

		                        <input id="nombre" type="text" class="form-control" name="nombre"  placeholder="nombre de la empresa" value="<?php echo $data['nombre']?>">
		                    </div>
	            		</div>
	            		<div class="col-md-6">
	            			<div class="mb-3">
		                        <label for="telefono" class="form-label">Telefono</label>
		                        <input id="telefono" type="text" class="form-control" name="telefono"  placeholder="telefono de la caja" value="<?php echo $data['telefono']?>">
		                    </div> 
	            		</div>
	            		<div class="col-md-6">
	            			<div class="mb-3">
		                        <label for="direccion" class="form-label">Direccion</label>
		                        <input id="direccion" type="text" class="form-control" name="direccion"  placeholder="telefono de la caja" value="<?php echo $data['direccion']?>">
		                    </div> 
	            		</div>
	            		
	            	</div>
                      
                    
                    <div class="mb-3">
                        <label for="mensaje" class="form-label">Mensaje</label>
                        <textarea id="mensaje" class="form-control" name="mensaje" rows="3" ><?php echo $data['mensaje']?></textarea> 
                    </div> 
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-primary" onclick="modificarEmpresa()" id="btnAccion">Modificar</button>
	            </div>
	        </form>
        </div>
	</div>



<?php include "Views/Templates/footer.php"; ?>
