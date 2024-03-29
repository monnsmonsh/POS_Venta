<?php
class Productos extends Controller
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
		//llamamos a los metodos dentro producto ::model getCategorias y getMedias
		$data['medidas'] = $this->model->getMedidas();
		$data['categorias'] = $this->model->getCategorias();

		//mostramos la VISTA
		$this->views->getView($this, "index", $data);
	}

    //llamamos al metodo getProductos
	public function listar()
	{
		//$data = $this->model->getProductos();
		//print_r($data);

		$data = ($this->model->getProductos());
		//generamos los botones de editar y eliminar
		for($i=0; $i< count($data); $i++){

			//par lista img
			$data[$i]['imagen'] ='<img class="img-thumbnail" style="width:100px;" src="'. base_url. "Assets/img/productos/". $data[$i]['foto'].'">';

			//valdiacion de estado de usuario
			if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';

                $data[$i]['acciones'] = '<div>
                	<button class="btn btn-primary" type="button" onclick="btnEditarPro(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                	<button class="btn btn-danger" type="button" onclick="btnEliminarPro(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>
                <div/>';
            }else{
            	$data[$i]['estado'] = '<span class="badge bg-danger">Inactivo</span>';

            	$data[$i]['acciones'] = '<div>
                	<button class="btn btn-success" type="button" onclick="btnReingresarPro('.$data[$i]['id'].');"><i class="fa-solid fa-circle"></i></button>
                <div/>';
            }
		}
		echo json_encode($data,JSON_UNESCAPED_UNICODE);
		die();
	}

	public function registrar(){
		//print_r($_POST);
		//validamos datos
		$codigo = $_POST['codigo'];
		$descripcion = $_POST['descripcion'];
		$precio_compra = $_POST['precio_compra'];
		$precio_venta = $_POST['precio_venta'];
		$medida =$_POST['medida'];
		$categoria =$_POST['categoria'];
		$id =$_POST['id'];
		
		// var para img
		$img= $_FILES['imagen'];
			$name = $img['name'];
			$tmpname = $img['tmp_name'];
		//verificamos que tenemos algo por el metodo fiel
		$fecha = date("YmdHis");

		if(empty ($codigo) || empty ($descripcion) || empty ($precio_compra) || empty ($precio_venta) || empty ($medida) || empty ($categoria)){
			//
			$msg = "todos los campos son obligatorio";

		}else{
			//vrificamos si exite img
			if(!empty($name)){
				$imgNombre = $fecha . ".jpg";
				$destino = "Assets/img/productos/".$imgNombre;
			}else if(!empty($_POST['foto_actual']) && empty($name)){
				$imgNombre = $_POST['foto_actual'];
			}else{
				$imgNombre ="default.jpg";
			}
			//si es un nuevo registro lo registramos
			if($id == ""){
				// con parametro 6
				$data = $this->model->registrarProducto($codigo, $descripcion, $precio_compra, $precio_venta, $medida, $categoria, $imgNombre);
				//verificamos la respusta caja
				if($data == "ok"){
					if (!empty($name)) {
						//movemos la img a la carpeta def
						move_uploaded_file($tmpname, $destino);
					}
					//$msg = "usuario registrar con exito";
					//cambiamos msg para realziar una validacion
					$msg = "si";
					
				}else if($data == "exite"){
					$msg = "¡¡Error!! El usuario ya existe";
				}else{
					$msg ="error al aregistrar el usuario";
				}
			}else{
				//eliminar img remplasasa
				$imgDelete = $data = $this->model->editarProducto($id);
				if ($imgDelete['foto'] !='default.jpg'){
					if(file_exists("Assets/img/productos/" . $imgDelete['foto'])){
						unlink("Assets/img/productos/" . $imgDelete['foto']);
					}
				}
				$data = $this->model->modificarProducto($codigo, $descripcion, $precio_compra, $precio_venta, $medida, $categoria, $imgNombre, $id);
				//verificamos la respusta caja
				if($data == "modificado"){
					if (!empty($name)) {
						//movemos la img a la carpeta def
						move_uploaded_file($tmpname, $destino);
					}
					//$msg = "producto modificado con exito";
					//cambiamos msg para realziar una validacion
					$msg = "modificado";
				}else{
					$msg ="Error al modificar el producto";
				}
				
			}
			
		}
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		die();

	}

	public function editar(int $id)
	{
		$data = $this->model->editarProducto($id);
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
		die();
	}

	public function eliminar(int $id)
	{
		//print_r($id);
		//llamos al metodo "accionProducto"
		$data = $this->model->accionProducto(0, $id);
		//validamos
		if ($data == 1) {
			$msg = "ok";
		}else{
			$msg ="Error al eliminar el Producto";
		}
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		die(); 
	}

	public function reingresar(int $id)
	{
		//print_r($id);
		//llamos al metodo "accionProducto"
		$data = $this->model->accionProducto(1, $id);
		//validamos
		if ($data == 1) {
			$msg = "ok";
		}else{
			$msg ="Error al reingresar el Producto";
		}
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		die(); 
	}



}

?>