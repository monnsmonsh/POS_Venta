<?php
class Usuarios extends Controller
{
	//Para que la seccion funcione debe inicializarlo dentro de contructor
	public function __construct() 
	{
		//iniciamos seccion
        session_start();
        /**
		if (empty($_SESSION['activo'])) {
            header("location: ".base_url);
        }
       */
		
        //cargamos el constructor de la instancia
        parent::__construct();
    }

	public function index()
	{
		
		if (empty($_SESSION['activo'])) {
            header("location: ".base_url);
        }
       
		//accedemos a la accion getUsuario
		//print_r($this->model->getUsuario());

		//llamamos a un metodo dentro usuariomodel getCajas
		$data['cajas'] = $this->model->getCajas();

		//mostramos la VISTA
		$this->views->getView($this, "index", $data);
	}

    //llamamos al metodo getUsuarios
	public function listar()
	{
		$data = ($this->model->getUsuarios());
		//generamos los botones de editar y eliminar
		for($i=0; $i< count($data); $i++){
			//valdiacion de estado de usuario
			if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';

                $data[$i]['acciones'] = '<div>
                	<button class="btn btn-primary" type="button" onclick="btnEditarUser(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                	<button class="btn btn-danger" type="button" onclick="btnEliminarUser(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>
                <div/>';
            }else{
            	$data[$i]['estado'] = '<span class="badge bg-danger">Inactivo</span>';

            	$data[$i]['acciones'] = '<div>
                	<button class="btn btn-success" type="button" onclick="btnReingresarUser('.$data[$i]['id'].');"><i class="fa-solid fa-circle"></i></button>
                <div/>';
            }
		}
		echo json_encode($data,JSON_UNESCAPED_UNICODE);
		die();
	}


	public function validar()
	{
		//verificamos los valores
		 if (empty($_POST['usuario']) || empty($_POST['clave'])) {
            $msg = "Los campos estan vacios";
        }
        else{
			//validamos datos
			$usuario = $_POST['usuario'];
            $clave = $_POST['clave'];
            $hash = hash("SHA256", $clave);
            $data = $this->model->getUsuario($usuario, $hash);


			//Si exite algo en var $data inciamos seccion
			if ($data) {
				//validamos datos
                $_SESSION['id_usuario'] = $data['id'];
                $_SESSION['usuario'] = $data['usuario'];
                $_SESSION['nombre'] = $data['nombre'];
                //para 
                $_SESSION['activo'] = true;
                //monstramos mensaje de seccion inciada
                $msg = "ok";
            }
            else{
                $msg = "Usuario o contraseña incorrecta";
            }
		}
		//para la "ñ" utilizamos JSON_UNESCAPED_UNICODE
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
	}

	public function registrar(){
		//print_r($_POST);

		//validamos datos
		$usuario = $_POST['usuario'];
		$nombre = $_POST['nombre'];
		$clave = $_POST['clave'];
		$confirmar = $_POST['confirmar'];
		$caja =$_POST['caja'];

		$id =$_POST['id'];
		//emcriptamos
		$hash = hash("SHA256", $clave);

		if(empty ($usuario) || empty ($nombre) || empty ($caja)){
			//
			$msg = "todos los campos son obligatorio";

		}else{
			//si es un nuevo registro lo registramos
			if($id == ""){
				//realizamos validacion y de que las contraseñas coincidan
				if($clave != $confirmar){
					$msg = "las contraseñas no coinciden";
				}else{
					// con parametro 4
					$data = $this->model->registrarUsuario($usuario, $nombre, $hash, $caja);
					//verificamos la respusta caja
					if($data == "ok"){
						//$msg = "usuario registrar con exito";
						//cambiamos msg para realziar una validacion
						$msg = "si";
					}else if($data == "exite"){
						$msg = "¡¡Error!! El usuario ya existe";
					}else{
						$msg ="error al aregistrar el usuario";
					}
				}
			}else{
				$data = $this->model->modificarUsuario($usuario, $nombre, $caja, $id);
					//verificamos la respusta caja
					if($data == "modificado"){
						//$msg = "usuario modificado con exito";
						//cambiamos msg para realziar una validacion
						$msg = "modificado";
					}else{
						$msg ="Error al modificar el usuario";
					}

			}
			
		}
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		die();

	}

	public function editar(int $id)
	{
		$data = $this->model->editarUsuario($id);
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
		die();
	}
	public function eliminar(int $id)
	{
		//print_r($id);
		//llamos al metodo "accionUsuario"
		$data = $this->model->accionUsuario(0, $id);
		//validamos
		if ($data == 1) {
			$msg = "ok";
		}else{
			$msg ="Error al eliminar el Usuario";
		}
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		die(); 
	}
	public function reingresar(int $id)
	{
		//print_r($id);
		//llamos al metodo "accionUsuario"
		$data = $this->model->accionUsuario(1, $id);
		//validamos
		if ($data == 1) {
			$msg = "ok";
		}else{
			$msg ="Error al reingresar el Usuario";
		}
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		die(); 
	}

	public function salir(){
		session_destroy();
		header("location: ".base_url);
	}


}

?>