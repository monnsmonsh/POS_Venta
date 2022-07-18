<?php

class AdministracionModel extends Query{

	//las variables de la funcion de registro Clientes la ponemos privado
	private  $cajas, $id, $estado;

	public function __construct()
	{
		parent::__construct();
	}

	//para optener la lista de MEdidas
	public function getEmpresa()
	{
		//$sql = "SELECT * FROM medidas";
		$sql = "SELECT * FROM configuracion";
		$data = $this->select($sql);
		return $data;
	}

	public function modificar(string $ruc, string $nombre, string $telefono, string $direccion, string $mensaje, int $id )
	{
		// si no existe realizamos la isercion
		$sql = "UPDATE configuracion SET ruc =?, nombre =?, telefono =?, direccion =?, mensaje =? WHERE id = ?";



		$datos = array($ruc, $nombre, $telefono, $direccion, $mensaje, $id);
		//llamamos al meto "save" dentro 
		$data = $this->save($sql, $datos);
		if($data == 1){
			$res = "modificado";
		}else {
			$res = "error";
		}
		return $res;

	}


}


?>