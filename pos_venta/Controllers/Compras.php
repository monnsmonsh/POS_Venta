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

}
?>