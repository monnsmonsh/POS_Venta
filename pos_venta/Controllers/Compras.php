<?php
class Compras extends Controller{
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

	public function buscarCodigo($cod)
	{
		//print_r($cod);
		$data = $this->model->getProCod($cod);
		//print_r($data);
		//die();
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
		die();
	}

	public function ingresar()
	{
		//print_r($_POST);
		$id = $_POST['id'];
		$datos = $this->model->getProductos($id);
		//print_r($datos);

		//
		$id_producto = $datos['id'];
		$id_usuario = $_SESSION['id_usuario'];
		$precio = $datos['precio_compra'];
		$cantidad = $_POST['cantidad'];
		

		//funcion para aumentar cant de un mismo pro
		$comprobar = $this->model->consultarDetalle($id_producto, $id_usuario);
		if(empty($comprobar)){
			$sub_total = $precio * $cantidad;
			//almacenamos lo datos
			$data = $this->model->registrarDetalle($id_producto, $id_usuario, $precio, $cantidad, $sub_total);
			if($data == "ok"){
				$msg = "ok";
			}else{
				$msg = "Error al ingresar el producto";
			}
		}else{
			$total_cantidad = $comprobar['cantidad'] + $cantidad;
			$sub_total = $total_cantidad * $precio;
			//almacenamos lo datos
			$data = $this->model->actualizarDetalle($precio, $total_cantidad, $sub_total, $id_producto, $id_usuario);
			if($data == "modificado"){
				$msg = "modificado";
			}else{
				$msg = "Error al modificar el producto";
			}
		}
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		die();
	}

	public function listar()
	{
		$id_usuario = $_SESSION['id_usuario'];
		$data['detalle_compra'] = $this->model->getDetalle($id_usuario);
		$data['total_pagar'] = $this->model->calcularCompra($id_usuario);
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
		die();
	}
	public function delete($id)
	{
		//print_r($id);
		$data = $this->model->deleteDetalle($id);
		//verificamos que el registro ha sido eliminado
		if($data == 'ok'){
			//creamos la var $msg para crear un val en funciones
			$msg = 'ok';
		}else{
			$msg = 'error';
		}
		//retornamos la var $msg
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		die();
	}

	public function registrarCompra()
	{
		$id_usuario = $_SESSION['id_usuario'];
		$total = $this->model->calcularCompra($id_usuario);
		$data =$this->model->registrarCompra($total['total']);
		if($data == "ok"){
			$detalle = $this->model->getDetalle($id_usuario);
			$id_compra = $this->model->id_compra();
			foreach ($detalle as $row) {
				$cantidad = $row['cantidad'];
				$precio = $row['precio'];
				$id_pro = $row['id_producto'];
				$sub_total = $cantidad * $precio;
				$this->model->registrarDetalleCompra($id_compra['id'], $id_pro, $cantidad, $precio, $sub_total);
			}
			$msg = 'ok';

		}else{
			$msg = 'Error al realizar la compra';
		}
		//retornamos la var $msg
		echo json_encode($msg);
		die();
	}

}
?>