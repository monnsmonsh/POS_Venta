<?php

class UsuariosModel extends Query{

	//las variables de la funcion de registroUsuario la ponemos privado
	private $usuario, $nombre, $clave, $id_caja, $id, $estado;

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

	//para optener la lista de producton en el controlador
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

		//verificamos que no tengamos otro mismo usuario
		$verificar = "SELECT * FROM usuarios WHERE usuario ='$this->usuario'";
		$exite = $this->select($verificar);
		if(empty($exite)){
			// si no existe realizamos la isercion
			$sql = "INSERT INTO usuarios(usuario, nombre, clave, id_caja) VALUES (?,?,?,?)";
			$datos = array($this->usuario, $this->nombre, $this->clave, $this->id_caja);

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
	public function editarUsuario(int $id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = $id";
        $data = $this->select($sql);
        return $data;
	}
	
	//creamos la funcion de modificar donde indicamos que recibimos ()
	public function modificarUsuario(string $usuario, string $nombre, int $id_caja, int $id)
    {
		//acedemos a las var e igualamos el parametro
		$this->usuario = $usuario;
        $this->nombre = $nombre;
        $this->id = $id;
        $this->id_caja = $id_caja;

        $sql = "UPDATE usuarios SET usuario = ?, nombre = ?, id_caja = ? WHERE id = ?";
        $datos = array($this->usuario, $this->nombre, $this->id_caja, $this->id);

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
	public function accionUsuario(int $estado, int $id)
	{
		$this->id = $id;
		$this->estado = $estado;
		$sql = "UPDATE usuarios SET estado = ? WHERE id = ?";
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