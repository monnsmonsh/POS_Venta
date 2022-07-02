
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
            {'data' : 'acciones'}

	    ]
	});
})



function frmLogin(e){
	e.preventDefault();
	const usuario = document.getElementById("usuario");
	const clave = document.getElementById("clave");

	if(usuario.value == ""){
		clave.classList.remove("is-invalid");
		usuario.classList.add("is-invalid");
		usuario.focus();
	}
	else if(clave.value == ""){
		usuario.classList.remove("is-invalid");
		clave.classList.add("is-invalid");
		clave.focus();
	}
	else{
		const url = base_url + "Usuarios/validar";
		const frm = document.getElementById("frmLogin");
		const http = new XMLHttpRequest();
		http.open("POST", url, true);
		http.send(new FormData(frm));
		http.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				//parseamos nuestro mensaje
				const res = JSON.parse(this.responseText);
				if(res == "ok"){
					window.location = base_url + "Usuarios";
				}else{
					//mensaje de erro de usuario y/o clave
					document.getElementById("alerta").classList.remove("d-none");
					document.getElementById("alerta").innerHTML = res;
				}

				//console.log(this.responseText);
			} 
		}

	}
}

//crear usuario
function frmUsuario(){
	//accedemos al titulo de la ventana modal para cambiar el  titulo y el btn
	document.getElementById("title").innerHTML ="Nuevo Usuario"
	document.getElementById("btnAccion").innerHTML ="Registrar"
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