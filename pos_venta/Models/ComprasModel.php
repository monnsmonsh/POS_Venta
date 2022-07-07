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

	//para optener la lista de de productos para ingresar
	public function getProductos(int $id)
	{
		$sql = "SELECT *  FROM productos WHERE id = $id";
		$data = $this->select($sql);
		return $data;
	}

	public function registrarDetalle(int $id_producto, int $id_usuario, string $precio, int $cantidad, string $sub_total)
	{
		$sql = "INSERT INTO detallecompras(id_producto, id_usuario, precio, cantidad, sub_total) VALUES (?,?,?,?,?)";

		$datos = array($id_producto, $id_usuario, $precio, $cantidad, $sub_total);

		$data =$this->save($sql, $datos);

		if($data == 1){
			$res = "ok";
		}else {
			$res = "error";
		}
		return $res;
	}

	public function getDetalle(int $id)
	{
		//$sql = "SELECT * FROM detallecompras WHERE id_usuario = $id";
		$sql = "SELECT d.*, p.id, p.descripcion FROM detallecompras d INNER JOIN productos p ON d.id_producto = p.id WHERE d.id_usuario = $id";
		$data = $this->selectAll($sql);
		return $data;
	}
	
}


?>