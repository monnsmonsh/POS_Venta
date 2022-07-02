<?php include "Views/Templates/header.php"; ?>
	<!--<h1 class="mt-4">Dashboard</h1>-->
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Usuarios</li>
    </ol>

    <button class="btn btn-primary mb-2" type="submit" onclick="frmUsuario();">Nuevo</button>


		
	<div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Usuarios
        </div>
        <div class="card-body">
        	<table class="table table-hover" style="width:100%" id="tblUsuarios">
				<thead class="table-dark">
			    	<th>Id</th>
			    	<th>Usuario</th>
			    	<th>Nombre</th>
			    	<th>Caja</th>
			    	<th>Estado</th>
			    	<th></th>
				</thead>
				<tbody>
				    
				</tbody>
			</table>
        </div>
	</div>


	<div id="nuevo_usuario" class="modal" tabindex="-1">
		<div class="modal-dialog">
		    <div class="modal-content">
		    	<form method="post" id="frmUsuario">
				    <div class="modal-header">
				        <h5 class="modal-title" id="title">Nuevo Usuario</h5>
				        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				    </div>
				    <div class="modal-body">
				        <!--<form method="post" id="frmUsuarios">-->
		                <div class="mb-3">
		                  	<label for="usuario" class="form-label">Usuario</label>
		                  	<input type="hidden" id="id" name="id">
		                  	<input id="usuario" type="text" class="form-control" type="text" name="usuario"  placeholder="usuario">
		                </div>
		                <div class="mb-3">
		                  	<label for="nombre" class="form-label">Nombre</label>
		                  	<input id="nombre" type="text" class="form-control" type="text" name="nombre"  placeholder="nombre">
		                </div>
		                <div class="row" id="claves">
			                <div class="col-md-6">
			                    <div class="mb-3">
			                      <label for="clave" class="form-label">Contraseña</label>
			                      <input id="clave" type="password" class="form-control" name="clave"  placeholder="contraseña">
			                    </div>
			                </div>
			                <div class="col-md-6">
			                	<div class="mb-3">
			                      	<label for="confirmar" class="form-label">Confirmar Contraseña</label>
			                      	<input id="confirmar" type="password" class="form-control" name="confirmar"  placeholder="confirmar contraseña">
			                    </div>
			                </div>
		                </div>

		               	<div class="mb-3">
	                  		<label for="caja" class="form-label">Caja</label>
	                  		<select id ="caja" name="caja" class="form-select" >

	                    		<option selected>Selecciona una caja</option>
	                    		<?php foreach ($data['cajas'] as $row) { ?>
	                      		<option value="<?php echo $row['id']; ?>"><?php echo $row['caja']; ?></option>
	                    
	                    	<?php } ?>
	                    	</select>
	                	</div>
	                	<!--<button class="btn btn-primary mb-2" type="submit">Registrar</button>-->
			            <!--</form>-->       
			            
		                
				    </div>
				    <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				        <button type="button" class="btn btn-primary" onclick="registarUser(event);" id="btnAccion">Registrar</button>
				    </div>
				</form>
		    </div>
		</div>
	</div>

<?php include "Views/Templates/footer.php"; ?>

