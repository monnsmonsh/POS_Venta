<?php
class Usuarios extends Controller
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
		//accedemos a la accion getUsuario
		//print_r($this->model->getUsuario());

		//mostramos la VISTA
		$this->views->getView($this, "index");
	}

	public function validar()
	{
		//verificamos los valores
		 if (empty($_POST['usuario']) || empty($_POST['clave'])) {
            $msg = "Los campos estan vacios";
        }
        else{
			//validamos datos
			$usuario =$_POST['usuario'];
			$clave =$_POST['clave'];
			$data = $this->model->getUsuario($usuario, $clave);

			//Si exite algo en var $data inciamos seccion
			if ($data) {
				//validamos datos
                $_SESSION['id_usuario'] = $data['id'];
                $_SESSION['usuario'] = $data['usuario'];
                $_SESSION['nombre'] = $data['nombre'];
                //$_SESSION['activo'] = true;
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
}

?>