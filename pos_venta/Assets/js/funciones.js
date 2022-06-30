
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
	$("#nuevo_usuario").modal("show");
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
	if(usuario.value == "" || nombre.value == "" || clave.value == "" || caja.value == ""){
		//mostramos alerta con sweetalert2
		Swal.fire({
		  	position: 'top-center',
		  	icon: 'error',
		  	title: 'Todos los campos son obligatorios',
		  	showConfirmButton: false,
		  	timer: 2000
		})	
	}
	//realizamos validacion y de que las contraseñas coincidan
	else if(clave.value != confirmar.value){
		Swal.fire({
		  	position: 'top-center',
		  	icon: 'error',
		  	title: 'Las contraseñas no coinciden',
		  	showConfirmButton: false,
		  	timer: 2000
		})
	}
	else{
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

