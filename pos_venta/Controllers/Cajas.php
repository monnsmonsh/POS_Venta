<?php
class Cajas extends Controller
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
	//llamamos al metodo getCajas
	public function listar()
	{
		$data = ($this->model->getCajas());
		//generamos los botones de editar y eliminar
		for($i=0; $i< count($data); $i++){
			//valdiacion de estado de usuario
			if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';

                $data[$i]['acciones'] = '<div>
                	<button class="btn btn-primary" type="button" onclick="btnEditarCaj(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                	<button class="btn btn-danger" type="button" onclick="btnEliminarCaj(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>
                <div/>';
            }else{
            	$data[$i]['estado'] = '<span class="badge bg-danger">Inactivo</span>';
            	$data[$i]['acciones'] = '<div>
                	<button class="btn btn-success" type="button" onclick="btnReingresarCaj('.$data[$i]['id'].');"><i class="fa-solid fa-circle"></i></button>
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
		$caja = $_POST['caja'];

		$id =$_POST['id'];

		if(empty ($caja)){
			//
			$msg = "Todos los campos son obligatorio";

		}else{
			//si es un nuevo registro lo registramos
			if($id == ""){
				// con parametro 4
				$data = $this->model->registrarCaja($caja);
				//verificamos la respusta caja
				if($data == "ok"){
					//$msg = "Medida registrar con exito";
					//cambiamos msg para realziar una validacion
					$msg = "si";
				}else if($data == "exite"){
					$msg = "¡¡Error!! La caja ya existe";
				}else{
					$msg ="Error al aregistrar la caja";
				}

			}else{
				$data = $this->model->modificarCaja($caja, $id);
					//verificamos la respusta caja
					if($data == "modificado"){
						//$msg = "Medida modificado con exito";
						//cambiamos msg para realziar una validacion
						$msg = "modificado";
					}else{
						$msg ="Error al modificar la Caja";
					}

			}
			
		}
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		die();

	}

	public function editar(int $id)
	{
		$data = $this->model->editarCaja($id);
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
		die();
	}

	public function eliminar(int $id)
	{
		//print_r($id);
		//llamos al metodo "accionCaja"
		$data = $this->model->accionCaja(0, $id);
		//validamos
		if ($data == 1) {
			$msg = "ok";
		}else{
			$msg ="Error al eliminar la Caja";
		}
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		die(); 
	}

	public function reingresar(int $id)
	{
		//print_r($id);
		//llamos al metodo "accionMedida"
		$data = $this->model->accionCaja(1, $id);
		//validamos
		if ($data == 1) {
			$msg = "ok";
		}else{
			$msg ="Error al reingresar la Caja";
		}
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		die(); 
	}



}
?>