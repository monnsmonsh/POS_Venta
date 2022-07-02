<?php
class Clientes extends Controller
{
	//Para que la seccion funcione debe inicializarlo dentro de contructor
	public function __construct() 
	{
		//iniciamos seccion
        session_start();
		if (empty($_SESSION['activo'])) {
            header("location: ".base_url);
        }
        //cargamos el constructor de la instancia
        parent::__construct();
    }

	public function index()
	{
		//mostramos la VISTA
		$this->views->getView($this, "index");
	}
	//llamamos al metodo getClientes
	public function listar()
	{
		$data = ($this->model->getClientes());
		//generamos los botones de editar y eliminar
		for($i=0; $i< count($data); $i++){
			//valdiacion de estado de usuario
			if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';

                $data[$i]['acciones'] = '<div>
                	<button class="btn btn-primary" type="button" onclick="btnEditarCli(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                	<button class="btn btn-danger" type="button" onclick="btnEliminarCli(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>
                <div/>';
            }else{
            	$data[$i]['estado'] = '<span class="badge bg-danger">Inactivo</span>';
            	$data[$i]['acciones'] = '<div>
                	<button class="btn btn-success" type="button" onclick="btnReingresarCli('.$data[$i]['id'].');"><i class="fa-solid fa-circle"></i></button>
                <div/>';
            }
			
		}
		echo json_encode($data,JSON_UNESCAPED_UNICODE);
		die();
	}

	public function registrar()
	{
		//print_r($_POST);

		//validamos datos
		$dni = $_POST['dni'];
		$nombre = $_POST['nombre'];
		$telefono = $_POST['telefono'];
		$direccion = $_POST['direccion'];

		$id =$_POST['id'];

		if(empty ($dni) || empty ($nombre) || empty ($telefono) || empty ($direccion)){
			//
			$msg = "Todos los campos son obligatorio";

		}else{
			//si es un nuevo registro lo registramos
			if($id == ""){
				// con parametro 4
				$data = $this->model->registrarCliente($dni, $nombre, $telefono, $direccion);
				//verificamos la respusta caja
				if($data == "ok"){
					//$msg = "Cliente registrar con exito";
					//cambiamos msg para realziar una validacion
					$msg = "si";
				}else if($data == "exite"){
					$msg = "¡¡Error!! El dni ya existe";
				}else{
					$msg ="error al aregistrar el cliente";
				}

			}else{
				$data = $this->model->modificarCliente($dni, $nombre, $telefono, $direccion, $id);
					//verificamos la respusta caja
					if($data == "modificado"){
						//$msg = "cliente modificado con exito";
						//cambiamos msg para realziar una validacion
						$msg = "modificado";
					}else{
						$msg ="Error al modificar el Cliente";
					}

			}
			
		}
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		die();

	}

	public function editar(int $id)
	{
		$data = $this->model->editarCliente($id);
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
		die();
	}

	public function eliminar(int $id)
	{
		//print_r($id);
		//llamos al metodo "accionClientes"
		$data = $this->model->accionCliente(0, $id);
		//validamos
		if ($data == 1) {
			$msg = "ok";
		}else{
			$msg ="Error al eliminar el Cliente";
		}
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		die(); 
	}

	public function reingresar(int $id)
	{
		//print_r($id);
		//llamos al metodo "accionCliente"
		$data = $this->model->accionCliente(1, $id);
		//validamos
		if ($data == 1) {
			$msg = "ok";
		}else{
			$msg ="Error al reingresar el Cliente";
		}
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		die(); 
	}



}
?>