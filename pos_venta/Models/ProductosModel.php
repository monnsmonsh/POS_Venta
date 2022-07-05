<?php

class ProductosModel extends Query{

	//las variables de la funcion de registroUsuario la ponemos privado
	private $codigo, $descripcion, $precio_compra, $precio_venta, $id_medida, $id_categoria, $id, $estado;

	public function __construct()
	{
		parent::__construct();
	}

	public function getMedidas()
	{
		$sql = "SELECT * FROM medidas WHERE estado = 1";
		$data = $this->selectall($sql);
		return $data;
	}

	public function getCategorias()
	{
		$sql = "SELECT * FROM categorias WHERE estado = 1";
		$data = $this->selectall($sql);
		return $data;
	}



	//para optener la lista de producton en el controlador
	public function getProductos()
	{
		$sql = "SELECT p.*, m.id AS id_medida, m.nombre AS medida , c.id AS id_categoria, c.nombre AS categoria FROM productos p INNER JOIN medidas m ON p.id_medida = m.id INNER JOIN categorias c ON p.id_categoria = c.id " ;
		$data = $this->selectall($sql);
		return $data;
	}

	//creamos la funcion de resgistro donde indicamos que recibimos ()
	public function registrarProducto(string $codigo, string $descripcion, string $precio_compra, string $precio_venta, int $id_medida, int $id_categoria)
	{
		//acedemos a las var e igualamos el parametro
		$this->codigo= $codigo;
		$this->descripcion= $descripcion;
		$this->precio_compra= $precio_compra;
		$this->precio_venta= $precio_venta;
		$this->id_medida= $id_medida;
		$this->id_categoria= $id_categoria;

		//verificamos que no tengamos otro mismo usuario
		$verificar = "SELECT * FROM productos WHERE codigo ='$this->codigo'";

		//si exite un mismo product ::codigo
		$exite = $this->select($verificar);
		if(empty($exite)){
			// si no existe realizamos la isercion
			$sql = "INSERT INTO productos(codigo, descripcion, precio_compra, precio_venta, id_medida, id_categoria) VALUES (?,?,?,?,?,?)";
			$datos = array($this->codigo, $this->descripcion, $this->precio_compra, $this->precio_venta, $this->id_medida, $this->id_categoria);

			//llamamos al meto "save" dentro 
			$data = $this->save($sql, $datos);
			//para verificar
			if($data == 1){
				$res = "ok";
			}else{
				$res = "error";
			}

		}else{
			$res ="exite";
		}

		return $res;
	}

	//realizamos un metodo para realizar una consulta
	public function editarProducto(int $id)
    {
        $sql = "SELECT * FROM productos WHERE id = $id";
        $data = $this->select($sql);
        return $data;
	}
	
	//creamos la funcion de modificar donde indicamos que recibimos ()
	public function modificarProducto(string $codigo, string $descripcion, string $precio_compra, string $precio_venta, int $id_medida, int $id_categoria, int $id)
    {
		//acedemos a las var e igualamos el parametro
		$this->codigo= $codigo;
		$this->descripcion= $descripcion;
		$this->precio_compra= $precio_compra;
		$this->precio_venta= $precio_venta;
		$this->id_medida= $id_medida;
		$this->id_categoria= $id_categoria;

        $this->id = $id;

        $sql = "UPDATE productos SET codigo = ?, descripcion = ?, precio_compra = ?, precio_venta = ?,id_medida = ?, id_categoria = ? WHERE id = ?";
        $datos = array($this->codigo, $this->descripcion, $this->precio_compra, $this->precio_venta, $this->id_medida, $this->id_categoria, $this->id);

		//llamamos al meto "save" dentro 
		$data = $this->save($sql, $datos);
		//para verificar
		if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
	}

	//eliminamos producto y reactivamos (desavilitar)
	public function accionProducto(int $estado, int $id)
	{
		$this->id = $id;
		$this->estado = $estado;
		$sql = "UPDATE productos SET estado = ? WHERE id = ?";
		$datos =array($this->estado, $this->id);
		$data =$this->save($sql, $datos);
		return $data;
	}

	
}


?>