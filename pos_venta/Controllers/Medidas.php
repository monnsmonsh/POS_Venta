<?php
class Medidas extends Controller
{
	//Para que la seccion funcione debe inicializarlo dentro de contructor
	public function __construct() 
	{
		//iniciamos seccion
        session_start();
		
        //cargamos el constructor de la instancia
        parent::__construct();
    }

	public function index()
	{
		if (empty($_SESSION['activo'])) {
            header("location: ".base_url);
        }
		//mostramos la VISTA
		$this->views->getView($this, "index");
	}
	//llamamos al metodo getClientes
	public function listar()
	{
		$data = ($this->model->getMedidas());
		//generamos los botones de editar y eliminar
		for($i=0; $i< count($data); $i++){
			//valdiacion de estado de usuario
			if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';

                $data[$i]['acciones'] = '<div>
                	<button class="btn btn-primary" type="button" onclick="btnEditarMed(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                	<button class="btn btn-danger" type="button" onclick="btnEliminarMed(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>
                <div/>';
            }else{
            	$data[$i]['estado'] = '<span class="badge bg-danger">Inactivo</span>';
            	$data[$i]['acciones'] = '<div>
                	<button class="btn btn-success" type="button" onclick="btnReingresarMed('.$data[$i]['id'].');"><i class="fa-solid fa-circle"></i></button>
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
		$nombre = $_POST['nombre'];
		$nombre_corto = $_POST['nombre_corto'];

		$id =$_POST['id'];

		if(empty ($nombre) || empty ($nombre_corto)){
			//
			$msg = "Todos los campos son obligatorio";

		}else{
			//si es un nuevo registro lo registramos
			if($id == ""){
				// con parametro 4
				$data = $this->model->registrarMedida($nombre, $nombre_corto);
				//verificamos la respusta caja
				if($data == "ok"){
					//$msg = "Medida registrar con exito";
					//cambiamos msg para realziar una validacion
					$msg = "si";
				}else if($data == "exite"){
					$msg = "¡¡Error!! La medida ya existe";
				}else{
					$msg ="error al aregistrar la medida";
				}

			}else{
				$data = $this->model->modificarMedida($nombre, $nombre_corto, $id);
					//verificamos la respusta caja
					if($data == "modificado"){
						//$msg = "Medida modificado con exito";
						//cambiamos msg para realziar una validacion
						$msg = "modificado";
					}else{
						$msg ="Error al modificar la Medida";
					}

			}
			
		}
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		die();

	}

	public function editar(int $id)
	{
		$data = $this->model->editarMedida($id);
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
		die();
	}

	public function eliminar(int $id)
	{
		//print_r($id);
		//llamos al metodo "accionMedida"
		$data = $this->model->accionMedida(0, $id);
		//validamos
		if ($data == 1) {
			$msg = "ok";
		}else{
			$msg ="Error al eliminar la Medida";
		}
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		die(); 
	}

	public function reingresar(int $id)
	{
		//print_r($id);
		//llamos al metodo "accionMedida"
		$data = $this->model->accionMedida(1, $id);
		//validamos
		if ($data == 1) {
			$msg = "ok";
		}else{
			$msg ="Error al reingresar la Medidas";
		}
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		die(); 
	}



}
?>