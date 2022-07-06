
//recibimos la lista de usuarios
let tblUsuarios;
document.addEventListener("DOMContentLoaded", function(){
	tblUsuarios = $('#tblUsuarios').DataTable({
        ajax: {
            url: base_url + "Usuarios/listar",
            dataSrc: ''
        },
        columns: [
        	{'data' : 'id'},
        	{'data' : 'usuario'},
            {'data' : 'nombre'},
            //cambicamos en nombre que tiene caja en ves de id_caja
           	//{'data' : 'id_caja'},
           	{'data' : 'caja'},
           	//generamos un obj para estado
            {'data' : 'estado'},
           	//generamos un obj para las acciones
            {'data' : 'acciones'},

	    ],
	    language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
	});//Fin de la tabla Usuarios
})


//crear usuario
function frmUsuario(){
	//accedemos al titulo de la ventana modal para cambiar el  titulo y el btn
	document.getElementById("title").innerHTML ="Nuevo Usuario";
	document.getElementById("btnAccion").innerHTML ="Registrar";
	//muestra los input de las claves
	document.getElementById("claves").classList.remove("d-none");
	//reseteamos el frm
	document.getElementById("frmUsuario").reset();

	$("#nuevo_usuario").modal("show");

	document.getElementById("id").value ="";
}

//registra usuario
function registarUser(e){
	e.preventDefault();
	const usuario = document.getElementById("usuario");
	const nombre = document.getElementById("nombre");
	const clave = document.getElementById("clave");
	const confirmar = document.getElementById("confirmar");
	const caja = document.getElementById("caja");

	//realizamos validacions y verificamos:
	if(usuario.value == "" || nombre.value == "" || caja.value == ""){
		//mostramos alerta con sweetalert2
		Swal.fire({
		  	position: 'top-center',
		  	icon: 'error',
		  	title: 'Todos los campos son obligatorios',
		  	showConfirmButton: false,
		  	timer: 2000
		})	
	}else{
		const url = base_url + "Usuarios/registrar";
		const frm = document.getElementById("frmUsuario");
		const http = new XMLHttpRequest();
		http.open("POST", url, true);
		http.send(new FormData(frm));
		http.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				//console.log(this.responseText);
				const res= JSON.parse(this.responseText);
				if (res =="si"){
					Swal.fire({
					  	position: 'top-center',
					  	icon: 'success',
					  	title: 'Usuario registrado con exito',
					  	showConfirmButton: false,
					  	timer: 2000
					})
					//reseteamos frm
					frm.reset();
					//oculdamo el modal
					$('#nuevo_usuario').modal("hide");
					//recargamos la tbl
					tblUsuarios.ajax.reload();
				}
				//si el usuario es modificado
				else if(res == "modificado"){
					Swal.fire({
					  	position: 'top-center',
					  	icon: 'success',
					  	title: 'Usuario modificado con exito',
					  	showConfirmButton: false,
					  	timer: 2000
					})
					$('#nuevo_usuario').modal("hide")
					tblUsuarios.ajax.reload();
				}else{
					Swal.fire({
					  	position: 'top-center',
					  	icon: 'error',
					  	title: res,
					  	showConfirmButton: false,
					  	timer: 2000
					})
				}
			} 
		}
	}
}

//editar usuario
function btnEditarUser(id){
	//accedemos al titulo de la ventana modal para cambiar el tituloy el btn
	document.getElementById("title").innerHTML ="Actualizar Usuario"
	document.getElementById("btnAccion").innerHTML ="Modifcar"

	//obtenemos los datos para editar
	const url = base_url + "Usuarios/editar/"+id;
	const http = new XMLHttpRequest();
	http.open("GET", url, true);
	http.send();
	http.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			//console.log(this.responseText); 
			const res = JSON.parse(this.responseText);
			document.getElementById("id").value = res.id;
			//accedemos a los datos a editar
			document.getElementById("usuario").value = res.usuario;
			document.getElementById("nombre").value = res.nombre;
			document.getElementById("caja").value = res.id_caja;
			//ocultamos los input de las claves
			document.getElementById("claves").classList.add("d-none");
			$("#nuevo_usuario").modal("show");
		} 
	}	
}
//eliminar usuario
function btnEliminarUser(id){
	//alert(id);
	Swal.fire({
	  	title: '¿Estas seguro de eliminar?',
	  	text: "El usuario no se eliminara de forma permanete, solo cambiara el estado a inactivo",
	  	icon: 'warning',
	  	showCancelButton: true,
	  	confirmButtonColor: '#3085d6',
	  	cancelButtonColor: '#d33',
	  	confirmButtonText: 'SI',
	  	cancelButtonText: 'NO'
	}).then((result) => {
	  if (result.isConfirmed) {
	  	//enviamos el id

		//obtenemos los datos para editar
		const url = base_url + "Usuarios/eliminar/"+id;
		const http = new XMLHttpRequest();
		http.open("GET", url, true);
		http.send();
		http.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				//console.log(this.responseText);
				const res = JSON.parse(this.responseText);
				if (res == "ok") {
					Swal.fire(
				      'Mensaje!',
				      'Usuario eliminado con exito.',
				      'success'
				    )
					tblUsuarios.ajax.reload();
				}else{
					Swal.fire(
				      'Mensaje!',
				      res,
				      'error'
				    )
				}
			} 
		}

	    
	  }
	})
}

//Reingresar usuario
function btnReingresarUser(id){
	//alert(id);
	Swal.fire({
	  	title: '¿Estas seguro de reingresar?',
	  	icon: 'warning',
	  	showCancelButton: true,
	  	confirmButtonColor: '#3085d6',
	  	cancelButtonColor: '#d33',
	  	confirmButtonText: 'SI',
	  	cancelButtonText: 'NO'
	}).then((result) => {
	  if (result.isConfirmed) {
	  	//enviamos el id

		//obtenemos los datos para editar
		const url = base_url + "Usuarios/reingresar/"+id;
		const http = new XMLHttpRequest();
		http.open("GET", url, true);
		http.send();
		http.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				//console.log(this.responseText);
				const res = JSON.parse(this.responseText);
				if (res == "ok") {
					Swal.fire(
				      'Mensaje!',
				      'Usuario reigresado con exito.',
				      'success'
				    )
					tblUsuarios.ajax.reload();
				}else{
					Swal.fire(
				      'Mensaje!',
				      res,
				      'error'
				    )
				}
			} 
		}

	    
	  }
	})
}

//
//Fin usuarios






//
//Inicio de Cliente cleintes
//
//recibimos la lista de clientes
let tblClientes;
document.addEventListener("DOMContentLoaded", function(){
	tblClientes = $('#tblClientes').DataTable({
        ajax: {
            url: base_url + "Clientes/listar",
            dataSrc: ''
        },
        columns: [
        	{'data' : 'id'},
        	{'data' : 'dni'},
        	{'data' : 'nombre'},
            {'data' : 'telefono'},
           	{'data' : 'direccion'},
           	//generamos un obj para estado
            {'data' : 'estado'},
           	//generamos un obj para las acciones
            {'data' : 'acciones'},
	    ],
	    language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
	});
})
//crear cliente
function frmCliente(){
	//accedemos al titulo de la ventana modal para cambiar el  titulo y el btn
	document.getElementById("title").innerHTML = "Nuevo Cliente";
	document.getElementById("btnAccion").innerHTML = "Registrar";
	//reseteamos el frm
	document.getElementById("frmCliente").reset();

	$("#nuevo_cliente").modal("show");

	document.getElementById("id").value ="";
}

function registarCli(e){
	e.preventDefault();
	const dni = document.getElementById("dni");
	const nombre = document.getElementById("nombre");
	const telefono = document.getElementById("telefono");
	const direccion = document.getElementById("direccion");

	//realizamos validacions y verificamos:
	if(dni.value == "" || nombre.value == "" || telefono.value == "" || direccion.value == ""){
		//mostramos alerta con sweetalert2
		Swal.fire({
		  	position: 'top-center',
		  	icon: 'error',
		  	title: 'Todos los campos son obligatorios',
		  	showConfirmButton: false,
		  	timer: 2000
		})	
	}else{
		const url = base_url + "Clientes/registrar";
		const frm = document.getElementById("frmCliente");
		const http = new XMLHttpRequest();
		http.open("POST", url, true);
		http.send(new FormData(frm));
		http.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				//console.log(this.responseText);
				const res= JSON.parse(this.responseText);
				if (res =="si"){
					Swal.fire({
					  	position: 'top-center',
					  	icon: 'success',
					  	title: 'Cliente registrado con exito',
					  	showConfirmButton: false,
					  	timer: 2000
					})
					//reseteamos frm
					frm.reset();
					//oculdamo el modal
					$('#nuevo_cliente').modal("hide");
					//recargamos la tbl
					tblClientes.ajax.reload();
				}
				//si el usuario es modificado
				else if(res == "modificado"){
					Swal.fire({
					  	position: 'top-center',
					  	icon: 'success',
					  	title: 'Cliente modificado con exito',
					  	showConfirmButton: false,
					  	timer: 2000
					})
					$('#nuevo_cliente').modal("hide")
					tblClientes.ajax.reload();
				}else{
					Swal.fire({
					  	position: 'top-center',
					  	icon: 'error',
					  	title: res,
					  	showConfirmButton: false,
					  	timer: 2000
					})
				}
			} 
		}
	}
}

//editar cliente
function btnEditarCli(id){
	//accedemos al titulo de la ventana modal para cambiar el tituloy el btn
	document.getElementById("title").innerHTML ="Actualizar Cliente"
	document.getElementById("btnAccion").innerHTML ="Modifcar"

	//obtenemos los datos para editar
	const url = base_url + "Clientes/editar/"+id;
	const http = new XMLHttpRequest();
	http.open("GET", url, true);
	http.send();
	http.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			//console.log(this.responseText); 
			const res = JSON.parse(this.responseText);
			document.getElementById("id").value = res.id;
			//accedemos a los datos a editar
			document.getElementById("dni").value = res.dni;
			document.getElementById("nombre").value = res.nombre;
			document.getElementById("telefono").value = res.telefono;
			document.getElementById("direccion").value = res.direccion;
			$("#nuevo_cliente").modal("show");
		} 
	}	
}
//eliminar cliente
function btnEliminarCli(id){
	//alert(id);
	Swal.fire({
	  	title: '¿Estas seguro de eliminar?',
	  	text: "El cliente no se eliminara de forma permanete, solo cambiara el estado a inactivo",
	  	icon: 'warning',
	  	showCancelButton: true,
	  	confirmButtonColor: '#3085d6',
	  	cancelButtonColor: '#d33',
	  	confirmButtonText: 'SI',
	  	cancelButtonText: 'NO'
	}).then((result) => {
	  if (result.isConfirmed) {
	  	//enviamos el id

		//obtenemos los datos para editar
		const url = base_url + "Clientes/eliminar/"+id;
		const http = new XMLHttpRequest();
		http.open("GET", url, true);
		http.send();
		http.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				//console.log(this.responseText);
				const res = JSON.parse(this.responseText);
				if (res == "ok") {
					Swal.fire(
				      'Mensaje!',
				      'Cliente eliminado con exito.',
				      'success'
				    )
					tblClientes.ajax.reload();
				}else{
					Swal.fire(
				      'Mensaje!',
				      res,
				      'error'
				    )
				}
			} 
		}

	    
	  }
	})
}

//Reingresar cliente
function btnReingresarCli(id){
	//alert(id);
	Swal.fire({
	  	title: '¿Estas seguro de reingresar?',
	  	icon: 'warning',
	  	showCancelButton: true,
	  	confirmButtonColor: '#3085d6',
	  	cancelButtonColor: '#d33',
	  	confirmButtonText: 'SI',
	  	cancelButtonText: 'NO'
	}).then((result) => {
	  if (result.isConfirmed) {
	  	//enviamos el id

		//obtenemos los datos para editar
		const url = base_url + "Clientes/reingresar/"+id;
		const http = new XMLHttpRequest();
		http.open("GET", url, true);
		http.send();
		http.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				//console.log(this.responseText);
				const res = JSON.parse(this.responseText);
				if (res == "ok") {
					Swal.fire(
				      'Mensaje!',
				      'Cliente reigresado con exito.',
				      'success'
				    )
					tblClientes.ajax.reload();
				}else{
					Swal.fire(
				      'Mensaje!',
				      res,
				      'error'
				    )
				}
			} 
		}

	    
	  }
	})
}
//
//
//Fin Clientes





//
//Inicio de Medidas
//
//recibimos la lista de medidas
let tblMedidas;
document.addEventListener("DOMContentLoaded", function(){
	tblMedidas = $('#tblMedidas').DataTable({
        ajax: {
            url: base_url + "Medidas/listar",
            dataSrc: ''
        },
        columns: [
        	{'data' : 'id'},
        	{'data' : 'nombre'},
            {'data' : 'nombre_corto'},
           	//generamos un obj para estado
            {'data' : 'estado'},
           	//generamos un obj para las acciones
            {'data' : 'acciones'},
	    ],
	    language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
	});
})

//crear medida
function frmMedida(){
	//accedemos al titulo de la ventana modal para cambiar el  titulo y el btn
	document.getElementById("title").innerHTML = "Nueva Medida";
	document.getElementById("btnAccion").innerHTML = "Registrar";
	//reseteamos el frm
	document.getElementById("frmMedida").reset();
	$("#nueva_medida").modal("show");
	document.getElementById("id").value ="";
}

//registrar medida
function registarMed(e){
	e.preventDefault();
	const nombre = document.getElementById("nombre");
	const nombre_corto = document.getElementById("nombre_corto");

	//realizamos validacions y verificamos:
	if(nombre.value == "" || nombre_corto.value == ""){
		//mostramos alerta con sweetalert2
		Swal.fire({
		  	position: 'top-center',
		  	icon: 'error',
		  	title: 'Todos los campos son obligatorios',
		  	showConfirmButton: false,
		  	timer: 2000
		})	
	}else{
		const url = base_url + "Medidas/registrar";
		const frm = document.getElementById("frmMedida");
		const http = new XMLHttpRequest();
		http.open("POST", url, true);
		http.send(new FormData(frm));
		http.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				//console.log(this.responseText);
				const res= JSON.parse(this.responseText);
				if (res =="si"){
					Swal.fire({
					  	position: 'top-center',
					  	icon: 'success',
					  	title: 'Media registrado con exito',
					  	showConfirmButton: false,
					  	timer: 2000
					})
					//reseteamos frm
					frm.reset();
					//oculdamo el modal
					$('#nueva_medida').modal("hide");
					//recargamos la tbl
					tblMedidas.ajax.reload();
				}
				//si el medida es modificado
				else if(res == "modificado"){
					Swal.fire({
					  	position: 'top-center',
					  	icon: 'success',
					  	title: 'Medida modificado con exito',
					  	showConfirmButton: false,
					  	timer: 2000
					})
					$('#nueva_medida').modal("hide")
					tblMedidas.ajax.reload();
				}else{
					Swal.fire({
					  	position: 'top-center',
					  	icon: 'error',
					  	title: res,
					  	showConfirmButton: false,
					  	timer: 2000
					})
				}
			} 
		}
	}
}

//editar medida
function btnEditarMed(id){
	//accedemos al titulo de la ventana modal para cambiar el tituloy el btn
	document.getElementById("title").innerHTML ="Actualizar Medida"
	document.getElementById("btnAccion").innerHTML ="Modifcar"

	//obtenemos los datos para editar
	const url = base_url + "Medidas/editar/"+id;
	const http = new XMLHttpRequest();
	http.open("GET", url, true);
	http.send();
	http.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			//console.log(this.responseText); 
			const res = JSON.parse(this.responseText);
			document.getElementById("id").value = res.id;
			//accedemos a los datos a editar
			document.getElementById("nombre").value = res.nombre;
			document.getElementById("nombre_corto").value = res.nombre_corto;
			$("#nueva_medida").modal("show");
		} 
	}	
}
//eliminar medida
function btnEliminarMed(id){
	//alert(id);
	Swal.fire({
	  	title: '¿Estas seguro de eliminar?',
	  	text: "La Medida no se eliminara de forma permanete, solo cambiara el estado a inactivo",
	  	icon: 'warning',
	  	showCancelButton: true,
	  	confirmButtonColor: '#3085d6',
	  	cancelButtonColor: '#d33',
	  	confirmButtonText: 'SI',
	  	cancelButtonText: 'NO'
	}).then((result) => {
	  if (result.isConfirmed) {
	  	//enviamos el id

		//obtenemos los datos para editar
		const url = base_url + "Medidas/eliminar/"+id;
		const http = new XMLHttpRequest();
		http.open("GET", url, true);
		http.send();
		http.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				//console.log(this.responseText);
				const res = JSON.parse(this.responseText);
				if (res == "ok") {
					Swal.fire(
				      'Mensaje!',
				      'Medida eliminado con exito.',
				      'success'
				    )
					tblMedidas.ajax.reload();
				}else{
					Swal.fire(
				      'Mensaje!',
				      res,
				      'error'
				    )
				}
			} 
		}

	    
	  }
	})
}

//Reingresar media
function btnReingresarMed(id){
	//alert(id);
	Swal.fire({
	  	title: '¿Estas seguro de reingresar?',
	  	icon: 'warning',
	  	showCancelButton: true,
	  	confirmButtonColor: '#3085d6',
	  	cancelButtonColor: '#d33',
	  	confirmButtonText: 'SI',
	  	cancelButtonText: 'NO'
	}).then((result) => {
	  if (result.isConfirmed) {
	  	//enviamos el id

		//obtenemos los datos para editar
		const url = base_url + "Medidas/reingresar/"+id;
		const http = new XMLHttpRequest();
		http.open("GET", url, true);
		http.send();
		http.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				//console.log(this.responseText);
				const res = JSON.parse(this.responseText);
				if (res == "ok") {
					Swal.fire(
				      'Mensaje!',
				      'Medida reigresado con exito.',
				      'success'
				    )
					tblMedidas.ajax.reload();
				}else{
					Swal.fire(
				      'Mensaje!',
				      res,
				      'error'
				    )
				}
			} 
		}

	    
	  }
	})
}
//
//
//Fin Medidas









//
//Inicio de Cajas
//
//recibimos la lista de medidas

let tblCajas;
document.addEventListener("DOMContentLoaded", function(){
	tblCajas = $('#tblCajas').DataTable({
        ajax: {
            url: base_url + "Cajas/listar",
            dataSrc: ''
        },
        columns: [
        	{'data' : 'id'},
        	{'data' : 'caja'},
           	//generamos un obj para estado
            {'data' : 'estado'},
           	//generamos un obj para las acciones
            {'data' : 'acciones'},
	    ],
	    language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
	});
})

//crear caja
function frmCaja(){
	//accedemos al titulo de la ventana modal para cambiar el  titulo y el btn
	document.getElementById("title").innerHTML = "Nueva Caja";
	document.getElementById("btnAccion").innerHTML = "Registrar";
	//reseteamos el frm
	document.getElementById("frmCaja").reset();
	$("#nueva_caja").modal("show");
	document.getElementById("id").value ="";
}

//registrar caja
function registarCaj(e){
	e.preventDefault();
	const caja = document.getElementById("caja");

	//realizamos validacions y verificamos:
	if(caja.value == ""){
		//mostramos alerta con sweetalert2
		Swal.fire({
		  	position: 'top-center',
		  	icon: 'error',
		  	title: 'Todos los campos son obligatorios',
		  	showConfirmButton: false,
		  	timer: 2000
		})	
	}else{
		const url = base_url + "Cajas/registrar";
		const frm = document.getElementById("frmCaja");
		const http = new XMLHttpRequest();
		http.open("POST", url, true);
		http.send(new FormData(frm));
		http.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				//console.log(this.responseText);
				const res= JSON.parse(this.responseText);
				if (res =="si"){
					Swal.fire({
					  	position: 'top-center',
					  	icon: 'success',
					  	title: 'Caja registrado con exito',
					  	showConfirmButton: false,
					  	timer: 2000
					})
					//reseteamos frm
					frm.reset();
					//oculdamo el modal
					$('#nueva_caja').modal("hide");
					//recargamos la tbl
					tblCajas.ajax.reload();
				}
				//si el medida es modificado
				else if(res == "modificado"){
					Swal.fire({
					  	position: 'top-center',
					  	icon: 'success',
					  	title: 'Caja modificado con exito',
					  	showConfirmButton: false,
					  	timer: 2000
					})
					$('#nueva_caja').modal("hide")
					tblCajas.ajax.reload();
				}else{
					Swal.fire({
					  	position: 'top-center',
					  	icon: 'error',
					  	title: res,
					  	showConfirmButton: false,
					  	timer: 2000
					})
				}
			} 
		}
	}
}

//editar caja
function btnEditarCaj(id){
	//accedemos al titulo de la ventana modal para cambiar el tituloy el btn
	document.getElementById("title").innerHTML ="Actualizar Caja"
	document.getElementById("btnAccion").innerHTML ="Modifcar"

	//obtenemos los datos para editar
	const url = base_url + "Cajas/editar/"+id;
	const http = new XMLHttpRequest();
	http.open("GET", url, true);
	http.send();
	http.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			//console.log(this.responseText); 
			const res = JSON.parse(this.responseText);
			document.getElementById("id").value = res.id;
			//accedemos a los datos a editar
			document.getElementById("caja").value = res.caja;
			$("#nueva_caja").modal("show");
		} 
	}	
}
//eliminar medida
function btnEliminarCaj(id){
	//alert(id);
	Swal.fire({
	  	title: '¿Estas seguro de eliminar?',
	  	text: "La Caja no se eliminara de forma permanete, solo cambiara el estado a inactivo",
	  	icon: 'warning',
	  	showCancelButton: true,
	  	confirmButtonColor: '#3085d6',
	  	cancelButtonColor: '#d33',
	  	confirmButtonText: 'SI',
	  	cancelButtonText: 'NO'
	}).then((result) => {
	  if (result.isConfirmed) {
	  	//enviamos el id

		//obtenemos los datos para editar
		const url = base_url + "Cajas/eliminar/"+id;
		const http = new XMLHttpRequest();
		http.open("GET", url, true);
		http.send();
		http.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				//console.log(this.responseText);
				const res = JSON.parse(this.responseText);
				if (res == "ok") {
					Swal.fire(
				      'Mensaje!',
				      'Caja eliminado con exito.',
				      'success'
				    )
					tblCajas.ajax.reload();
				}else{
					Swal.fire(
				      'Mensaje!',
				      res,
				      'error'
				    )
				}
			} 
		}

	    
	  }
	})
}

//Reingresar media
function btnReingresarCaj(id){
	//alert(id);
	Swal.fire({
	  	title: '¿Estas seguro de reingresar?',
	  	icon: 'warning',
	  	showCancelButton: true,
	  	confirmButtonColor: '#3085d6',
	  	cancelButtonColor: '#d33',
	  	confirmButtonText: 'SI',
	  	cancelButtonText: 'NO'
	}).then((result) => {
	  if (result.isConfirmed) {
	  	//enviamos el id

		//obtenemos los datos para editar
		const url = base_url + "Cajas/reingresar/"+id;
		const http = new XMLHttpRequest();
		http.open("GET", url, true);
		http.send();
		http.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				//console.log(this.responseText);
				const res = JSON.parse(this.responseText);
				if (res == "ok") {
					Swal.fire(
				      'Mensaje!',
				      'Medida reigresado con exito.',
				      'success'
				    )
					tblCajas.ajax.reload();
				}else{
					Swal.fire(
				      'Mensaje!',
				      res,
				      'error'
				    )
				}
			} 
		}

	    
	  }
	})
}
//
//
//Fin Cajas







//
//Inicio de CATEGORIAS
//
//recibimos la lista de medidas
let tblCategorias;
document.addEventListener("DOMContentLoaded", function(){
	tblCategorias = $('#tblCategorias').DataTable({
        ajax: {
            url: base_url + "Categorias/listar",
            dataSrc: ''
        },
        columns: [
        	{'data' : 'id'},
        	{'data' : 'nombre'},
           	//generamos un obj para estado
            {'data' : 'estado'},
           	//generamos un obj para las acciones
            {'data' : 'acciones'},
	    ],
	    language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
	});
})

//crear caja
function frmCategoria(){
	//accedemos al titulo de la ventana modal para cambiar el  titulo y el btn
	document.getElementById("title").innerHTML = "Nueva Categoria";
	document.getElementById("btnAccion").innerHTML = "Registrar";
	//reseteamos el frm
	document.getElementById("frmCategoria").reset();
	$("#nueva_categoria").modal("show");
	document.getElementById("id").value ="";
}

//registrar caja
function registarCat(e){
	e.preventDefault();
	const nombre = document.getElementById("nombre");

	//realizamos validacions y verificamos:
	if(nombre.value == ""){
		//mostramos alerta con sweetalert2
		Swal.fire({
		  	position: 'top-center',
		  	icon: 'error',
		  	title: 'Todos los campos son obligatorios',
		  	showConfirmButton: false,
		  	timer: 2000
		})	
	}else{
		const url = base_url + "Categorias/registrar";
		const frm = document.getElementById("frmCategoria");
		const http = new XMLHttpRequest();
		http.open("POST", url, true);
		http.send(new FormData(frm));
		http.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				//console.log(this.responseText);
				const res= JSON.parse(this.responseText);
				if (res =="si"){
					Swal.fire({
					  	position: 'top-center',
					  	icon: 'success',
					  	title: 'Categoria registrado con exito',
					  	showConfirmButton: false,
					  	timer: 2000
					})
					//reseteamos frm
					frm.reset();
					//oculdamo el modal
					$('#nueva_categoria').modal("hide");
					//recargamos la tbl
					tblCategorias.ajax.reload();
				}
				//si el medida es modificado
				else if(res == "modificado"){
					Swal.fire({
					  	position: 'top-center',
					  	icon: 'success',
					  	title: 'Categoria modificado con exito',
					  	showConfirmButton: false,
					  	timer: 2000
					})
					$('#nueva_categoria').modal("hide")
					tblCategorias.ajax.reload();
				}else{
					Swal.fire({
					  	position: 'top-center',
					  	icon: 'error',
					  	title: res,
					  	showConfirmButton: false,
					  	timer: 2000
					})
				}
			} 
		}
	}
}

//editar caja
function btnEditarCat(id){
	//accedemos al titulo de la ventana modal para cambiar el tituloy el btn
	document.getElementById("title").innerHTML ="Actualizar Categoria"
	document.getElementById("btnAccion").innerHTML ="Modifcar"

	//obtenemos los datos para editar
	const url = base_url + "Categorias/editar/"+id;
	const http = new XMLHttpRequest();
	http.open("GET", url, true);
	http.send();
	http.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			//console.log(this.responseText); 
			const res = JSON.parse(this.responseText);
			document.getElementById("id").value = res.id;
			//accedemos a los datos a editar
			document.getElementById("nombre").value = res.nombre;
			$("#nueva_categoria").modal("show");
		} 
	}	
}
//eliminar categorias
function btnEliminarCat(id){
	//alert(id);
	Swal.fire({
	  	title: '¿Estas seguro de eliminar?',
	  	text: "La Categoria no se eliminara de forma permanete, solo cambiara el estado a inactivo",
	  	icon: 'warning',
	  	showCancelButton: true,
	  	confirmButtonColor: '#3085d6',
	  	cancelButtonColor: '#d33',
	  	confirmButtonText: 'SI',
	  	cancelButtonText: 'NO'
	}).then((result) => {
	  if (result.isConfirmed) {
	  	//enviamos el id

		//obtenemos los datos para editar
		const url = base_url + "Categorias/eliminar/"+id;
		const http = new XMLHttpRequest();
		http.open("GET", url, true);
		http.send();
		http.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				//console.log(this.responseText);
				const res = JSON.parse(this.responseText);
				if (res == "ok") {
					Swal.fire(
				      'Mensaje!',
				      'Categoria eliminado con exito.',
				      'success'
				    )
					tblCategorias.ajax.reload();
				}else{
					Swal.fire(
				      'Mensaje!',
				      res,
				      'error'
				    )
				}
			} 
		}

	    
	  }
	})
}

//Reingresar categoria
function btnReingresarCat(id){
	//alert(id);
	Swal.fire({
	  	title: '¿Estas seguro de reingresar?',
	  	icon: 'warning',
	  	showCancelButton: true,
	  	confirmButtonColor: '#3085d6',
	  	cancelButtonColor: '#d33',
	  	confirmButtonText: 'SI',
	  	cancelButtonText: 'NO'
	}).then((result) => {
	  if (result.isConfirmed) {
	  	//enviamos el id

		//obtenemos los datos para editar
		const url = base_url + "Categorias/reingresar/"+id;
		const http = new XMLHttpRequest();
		http.open("GET", url, true);
		http.send();
		http.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				//console.log(this.responseText);
				const res = JSON.parse(this.responseText);
				if (res == "ok") {
					Swal.fire(
				      'Mensaje!',
				      'Categorias reigresado con exito.',
				      'success'
				    )
					tblCategorias.ajax.reload();
				}else{
					Swal.fire(
				      'Mensaje!',
				      res,
				      'error'
				    )
				}
			} 
		}

	    
	  }
	})
}
//
//
//Fin CATEGORIAS



//
//Inicio de PRODUCTOS
//
//recibimos la lista de medidas
let tblProductos;
document.addEventListener("DOMContentLoaded", function(){
	tblProductos = $('#tblProductos').DataTable({
        ajax: {
            url: base_url + "Productos/listar",
            dataSrc: ''
        },
        columns: [
        	{'data' : 'id'},
        	{'data' : 'imagen'},
        	{'data' : 'codigo'},
        	{'data' : 'descripcion'},
        	{'data' : 'precio_venta'},
        	{'data' : 'cantidad'},
           	//generamos un obj para estado
            {'data' : 'estado'},
           	//generamos un obj para las acciones
            {'data' : 'acciones'},
	    ],
	    language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
	});
})

//crear caja
function frmProducto(){
	//accedemos al titulo de la ventana modal para cambiar el  titulo y el btn
	document.getElementById("title").innerHTML = "Nueva Producto";
	document.getElementById("btnAccion").innerHTML = "Registrar";
	//reseteamos el frm
	document.getElementById("frmProducto").reset();
	$("#nuevo_producto").modal("show");
	document.getElementById("id").value ="";

	//limpiar campos con iumg
	deleteImg();
}

//registrar producto
function registarPro(e){
	e.preventDefault();
	const codigo = document.getElementById("codigo");
	const descripcion = document.getElementById("descripcion");
	const precio_compra = document.getElementById("precio_compra");
	const precio_venta = document.getElementById("precio_venta");
	const id_medida = document.getElementById("medida");
	const id_categoria = document.getElementById("categoria");

	//realizamos validacions y verificamos:
	if(codigo.value == "" || descripcion.value == "" || precio_compra.value == "" || precio_venta.value == "" ){
		//mostramos alerta con sweetalert2
		Swal.fire({
		  	position: 'top-center',
		  	icon: 'error',
		  	title: 'Todos los campos son obligatorios',
		  	showConfirmButton: false,
		  	timer: 2000
		})	
	}else{
		const url = base_url + "Productos/registrar";
		const frm = document.getElementById("frmProducto");
		const http = new XMLHttpRequest();
		http.open("POST", url, true);
		http.send(new FormData(frm));
		http.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				//console.log(this.responseText);
				const res= JSON.parse(this.responseText);
				if (res =="si"){
					Swal.fire({
					  	position: 'top-center',
					  	icon: 'success',
					  	title: 'Producto registrado con exito',
					  	showConfirmButton: false,
					  	timer: 2000
					})
					//reseteamos frm
					frm.reset();
					//oculdamo el modal
					$('#nuevo_producto').modal("hide");
					//recargamos la tbl
					tblProductos.ajax.reload();
				}
				//si el medida es modificado
				else if(res == "modificado"){
					Swal.fire({
					  	position: 'top-center',
					  	icon: 'success',
					  	title: 'Producto modificado con exito',
					  	showConfirmButton: false,
					  	timer: 2000
					})
					$('#nuevo_producto').modal("hide")
					tblProductos.ajax.reload();
				}else{
					Swal.fire({
					  	position: 'top-center',
					  	icon: 'error',
					  	title: res,
					  	showConfirmButton: false,
					  	timer: 2000
					})
				}
			} 
		}
	}
}

//editar Producto
function btnEditarPro(id){
	//accedemos al titulo de la ventana modal para cambiar el tituloy el btn
	document.getElementById("title").innerHTML ="Actualizar Producto"
	document.getElementById("btnAccion").innerHTML ="Modifcar"

	//obtenemos los datos para editar
	const url = base_url + "Productos/editar/"+id;
	const http = new XMLHttpRequest();
	http.open("GET", url, true);
	http.send();
	http.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			//console.log(this.responseText); 
			const res = JSON.parse(this.responseText);
			document.getElementById("id").value = res.id;
			//accedemos a los datos a editar
			document.getElementById("codigo").value = res.codigo;
			document.getElementById("descripcion").value = res.descripcion;
			document.getElementById("precio_compra").value = res.precio_compra;
			document.getElementById("precio_venta").value = res.precio_venta;
			document.getElementById("media").value = res.id_medida;
			document.getElementById("categoria").value = res.id_categoria;

			//obtenr img
			document.getElementById("img-preview").src = base_url+'Assets/img/productos/'+res.foto;
			document.getElementById("icon-cerrar").innerHTML= `
				<button class="btn btn-danger" onclick="deleteImg()">
					<i class="fas fa-times"></i>
				</button>`;
			//monstrar la calses dis
			document.getElementById("icon-image").classList.add("d-none");
			
			document.getElementById("foto_actual").value = res.foto;
			
			$("#nuevo_producto").modal("show");
		} 
	}	
}
//eliminar Producto
function btnEliminarPro(id){
	//alert(id);
	Swal.fire({
	  	title: '¿Estas seguro de eliminar?',
	  	text: "La Categoria no se eliminara de forma permanete, solo cambiara el estado a inactivo",
	  	icon: 'warning',
	  	showCancelButton: true,
	  	confirmButtonColor: '#3085d6',
	  	cancelButtonColor: '#d33',
	  	confirmButtonText: 'SI',
	  	cancelButtonText: 'NO'
	}).then((result) => {
	  if (result.isConfirmed) {
	  	//enviamos el id

		//obtenemos los datos para editar
		const url = base_url + "Productos/eliminar/"+id;
		const http = new XMLHttpRequest();
		http.open("GET", url, true);
		http.send();
		http.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				//console.log(this.responseText);
				const res = JSON.parse(this.responseText);
				if (res == "ok") {
					Swal.fire(
				      'Mensaje!',
				      'Producto eliminado con exito.',
				      'success'
				    )
					tblProductos.ajax.reload();
				}else{
					Swal.fire(
				      'Mensaje!',
				      res,
				      'error'
				    )
				}
			} 
		}

	    
	  }
	})
}

//Reingresar categoria
function btnReingresarPro(id){
	//alert(id);
	Swal.fire({
	  	title: '¿Estas seguro de reingresar?',
	  	icon: 'warning',
	  	showCancelButton: true,
	  	confirmButtonColor: '#3085d6',
	  	cancelButtonColor: '#d33',
	  	confirmButtonText: 'SI',
	  	cancelButtonText: 'NO'
	}).then((result) => {
	  if (result.isConfirmed) {
	  	//enviamos el id

		//obtenemos los datos para editar
		const url = base_url + "Productos/reingresar/"+id;
		const http = new XMLHttpRequest();
		http.open("GET", url, true);
		http.send();
		http.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				//console.log(this.responseText);
				const res = JSON.parse(this.responseText);
				if (res == "ok") {
					Swal.fire(
				      'Mensaje!',
				      'Producto reigresado con exito.',
				      'success'
				    )
					tblProductos.ajax.reload();
				}else{
					Swal.fire(
				      'Mensaje!',
				      res,
				      'error'
				    )
				}
			} 
		}

	    
	  }
	})
}

//para monstrar la img
function preview(e){
	//console.log(e.target.files);
	//alamcenamos la img en una cosnt
	const url = e.target.files[0];
	const urlTmp = URL.createObjectURL(url);
	//motramos img seleccionada
	document.getElementById("img-preview").src = urlTmp;
	//para ocultar el ico una ves que tengamos img
	document.getElementById("icon-image").classList.add("d-none");

	document.getElementById("icon-cerrar").innerHTML= `
	<button class="btn btn-danger" onclick="deleteImg()"><i class="fas fa-times"></i></button>
	${url['name']}`;


}
//para eliminar la img
function deleteImg(){
	document.getElementById("icon-cerrar").innerHTML='';
	//monstrar la calses dis
	document.getElementById("icon-image").classList.remove("d-none");
	//quitar vista prev
	document.getElementById("img-preview").src = '';
	document.getElementById("imagen").value ='';

	document.getElementById("foto_actual").value ='';
}
//
//
//Fin PRODUCTOS


//
//Inicio de COMPRAS
//<--funciones para comprar
function buscarCodigo(e){
	e.preventDefault();
	//para que solo busque si se da enter
	if(e.which == 13){
		const cod = document.getElementById("codigo").value;
		//obtenemos los datos para de codigo productos
		const url = base_url + "Compras/buscarCodigo/"+cod;
		const http = new XMLHttpRequest();
		http.open("GET", url, true);
		http.send();
		http.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				//console.log(this.responseText);
				//pasamos la info en..
				const res = JSON.parse(this.responseText);
				//verificamos que exista el cod
				if(res){
					//mostramos inf en los inpt (nombre de imput) (nombre del arry)
					document.getElementById("descripcion").value = res.descripcion;
					document.getElementById("precio").value = res.precio_compra;
					document.getElementById("id").value = res.id;

					document.getElementById("cantidad").focus();
				}else{
					//alert("Producto no existente")
					Swal.fire({
					  	position: 'top-center',
					  	icon: 'error',
					  	title: 'Producto no existente',
					  	showConfirmButton: false,
					  	timer: 2000
					})
					document.getElementById("codigo").value = '';
					document.getElementById("codigo").focus();
				}

			} 
		}
	}
}

function calcularPrecio(e){
	e.preventDefault();
	const cant = document.getElementById("cantidad").value;
	const precio = document.getElementById("precio").value;

	document.getElementById("sub_total").value = precio * cant;
}