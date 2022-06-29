<?php

class UsuariosModel extends Query{
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
		$sql = "SELECT u.*, c.id, c.caja FROM usuarios u INNER JOIN caja c WHERE u.id_caja = c.id";
		$data = $this->selectall($sql);
		return $data;
	}


	public function getCajas()
	{
		$sql = "SELECT * FROM caja WHERE estado = 1";
		$data = $this->selectall($sql);
		return $data;
	}
}


?>