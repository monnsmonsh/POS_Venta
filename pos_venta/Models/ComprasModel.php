<?php

class ComprasModel extends Query{

	//las variables de la funcion de registro Clientes la ponemos privado
	private  $nombre, $id, $estado;

	public function __construct()
	{
		parent::__construct();
	}

	//para optener la lista de codigo de productos
	public function getProCod(string $cod)
	{
		$sql = "SELECT *  FROM productos WHERE codigo = '$cod'";
		$data = $this->select($sql);
		return $data;
	}

	
}


?>