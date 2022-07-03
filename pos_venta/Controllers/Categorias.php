<?php
class Categorias extends Controller
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
		$data = ($this->model->getCategorias());
		//generamos los botones de editar y eliminar
		for($i=0; $i< count($data); $i++){
			//valdiacion de estado de usuario
			if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';

                $data[$i]['acciones'] = '<div>
                	<button class="btn btn-primary" type="button" onclick="btnEditarCat(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                	<button class="btn btn-danger" type="button" onclick="btnEliminarCat(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>
                <div/>';
            }else{
            	$data[$i]['estado'] = '<span class="badge bg-danger">Inactivo</span>';
            	$data[$i]['acciones'] = '<div>
                	<button class="btn btn-success" type="button" onclick="btnReingresarCat('.$data[$i]['id'].');"><i class="fa-solid fa-circle"></i></button>
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
		$id =$_POST['id'];
		if(empty ($nombre)){
			//
			$msg = "Todos los campos son obligatorio";
		}else{
			//si es un nuevo registro lo registramos
			if($id == ""){
				// con parametro 4
				$data = $this->model->registrarCategoria($nombre);
				//verificamos la respusta caja
				if($data == "ok"){
					//$msg = "Medida registrar con exito";
					//cambiamos msg para realziar una validacion
					$msg = "si";
				}else if($data == "exite"){
					$msg = "¡¡Error!! La categoria ya existe";
				}else{
					$msg ="Error al aregistrar la categoria";
				}

			}else{
				$data = $this->model->modificarCategoria($nombre, $id);
					//verificamos la respusta caja
					if($data == "modificado"){
						//$msg = "Medida modificado con exito";
						//cambiamos msg para realziar una validacion
						$msg = "modificado";
					}else{
						$msg ="Error al modificar la categoria";
					}
			}
			
		}
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		die();

	}

	public function editar(int $id)
	{
		$data = $this->model->editarCategoria($id);
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
		die();
	}

	public function eliminar(int $id)
	{
		//print_r($id);
		//llamos al metodo "accionCategoria"
		$data = $this->model->accionCategoria(0, $id);
		//validamos
		if ($data == 1) {
			$msg = "ok";
		}else{
			$msg ="Error al eliminar la Categoria";
		}
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		die(); 
	}

	public function reingresar(int $id)
	{
		//print_r($id);
		//llamos al metodo "accionMedida"
		$data = $this->model->accionCategoria(1, $id);
		//validamos
		if ($data == 1) {
			$msg = "ok";
		}else{
			$msg ="Error al reingresar la Categoria";
		}
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		die(); 
	}



}
?>