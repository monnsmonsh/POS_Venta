<?php

class ClientesModel extends Query{

	//las variables de la funcion de registro Clientes la ponemos privado
	private $dni, $nombre, $telefono, $direccion, $id, $estado;

	public function __construct()
	{
		parent::__construct();
	}

	//para optener la lista de CLIENTES en el controlador
	public function getClientes()
	{
		//$sql = "SELECT * FROM clientes";
		$sql = "SELECT * FROM clientes";
		$data = $this->selectall($sql);
		return $data;
	}

	//creamos la funcion de resgistro donde indicamos que recibimos ()
	public function registrarCliente(string $dni, string $nombre,string $telefono, string $direccion)
	{
		//acedemos a las var e igualamos el parametro
		$this->dni= $dni;
		$this->nombre= $nombre;
		$this->telefono= $telefono;
		$this->direccion= $direccion;

		//verificamos que no tengamos otro mismo cliente
		$verificar = "SELECT * FROM clientes WHERE dni ='$this->dni'";
		$exite = $this->select($verificar);
		if(empty($exite)){
			// si no existe realizamos la isercion
			$sql = "INSERT INTO clientes(dni, nombre, telefono, direccion) VALUES (?,?,?,?)";
			$datos = array($this->dni, $this->nombre, $this->telefono, $this->direccion);

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
	public function editarCliente(int $id)
    {
        $sql = "SELECT * FROM clientes WHERE id = $id";
        $data = $this->select($sql);
        return $data;
	}
	
	//creamos la funcion de modificar donde indicamos que recibimos ()
	public function modificarCliente(string $dni, string $nombre, string $telefono, string $direccion, int $id)
    {
		//acedemos a las var e igualamos el parametro
		$this->dni = $dni;
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
        $this->id = $id;

        $sql = "UPDATE clientes SET dni = ?, nombre = ?, telefono = ? , direccion = ? WHERE id = ?";
        $datos = array($this->dni, $this->nombre, $this->telefono, $this->direccion, $this->id);

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

	//eliminamos usuario y reactivamos (desavilitar)
	public function accionCliente(int $estado, int $id)
	{
		$this->id = $id;
		$this->estado = $estado;
		$sql = "UPDATE clientes SET estado = ? WHERE id = ?";
		$datos =array($this->estado, $this->id);
		$data =$this->save($sql, $datos);
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