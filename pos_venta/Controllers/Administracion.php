<?php
/**
 *  c
 */
class Administracion extends Controller
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
		$data = $this->model->getEmpresa();
		//mostramos la VISTA
		$this->views->getView($this, "index", $data);
	}

	public function modificar()
	{
		//print_r($_POST);
		$ruc = $_POST['ruc'];
		$nombre = $_POST['nombre'];
		$telefono = $_POST['telefono'];
		$direccion = $_POST['direccion'];
		$mensaje = $_POST['mensaje'];
		$id = $_POST['id'];

		$data = $this->model->modificar($ruc, $nombre, $telefono, $direccion, $mensaje, $id); 
		if($data == 'modificado'){
			$msg = 'modificado';
		}else{
			$msg = 'error';
		}
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		die();
	}
}
?>