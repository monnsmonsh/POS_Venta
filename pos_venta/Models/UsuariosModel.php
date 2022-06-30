<?php

class UsuariosModel extends Query{

	//las variables de la funcion de registroUsuario la ponemos privado
	private $usuario, $nombre, $clave, $id_caja;

	public function __construct()
	{
		parent::__construct();
	}
	public function getUsuario(string $usuario, string $clave)
	{
		$sql = "SELECT * FROM usuarios WHERE usuario ='$usuario' AND clave = '$clave'";
		$data = $this->select($sql);
		return $data;
	}

	//para optener la lista de usuarios
	public function getUsuarios()
	{
		//$sql = "SELECT * FROM usuarios";
		$sql = "SELECT u.*, c.id as id_caja, c.caja FROM usuarios u INNER JOIN caja c WHERE u.id_caja = c.id";
		$data = $this->selectall($sql);
		return $data;
	}

	//creamos la funcion de resgistro donde indicamos que recibimos ()
	public function registrarUsuario(string $usuario, string $nombre,string $clave, int $id_caja)
	{
		//acedemos a las var e igualamos el parametro
		$this->usuario= $usuario;
		$this->nombre= $nombre;
		$this->clave= $clave;
		$this->id_caja= $id_caja;

		$sql = "INSERT INTO usuarios(usuario, nombre, clave, id_caja) VALUES (?,?,?,?)";
		$datos = array($this->usuario, $this->nombre, $this->clave, $this->id_caja);

		//llamamos al meto "save" dentro 
		$data = $this->save($sql, $datos);
		//para verificar
		if($data == 1){
			$res = "ok";
		}else{
			$res = "erro";
		}
		return $res;
	}


	public function getCajas()
	{
		$sql = "SELECT * FROM caja WHERE estado = 1";
		$data = $this->selectall($sql);
		return $data;
	}
}


?>