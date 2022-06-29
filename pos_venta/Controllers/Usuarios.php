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
            }else{
            	$data[$i]['estado'] = '<span class="badge bg-danger">Inactivo</span>';
            }

             
			$data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button"> Editar</button>
                <button class="btn btn-danger" type="button">Eliminar</button>
                <div/>';
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