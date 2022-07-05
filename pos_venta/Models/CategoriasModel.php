<?php

class CategoriasModel extends Query{

	//las variables de la funcion de registro Clientes la ponemos privado
	private  $nombre, $id, $estado;

	public function __construct()
	{
		parent::__construct();
	}

	//para optener la lista de CATEGORIAS en el controlador
	public function getCategorias()
	{
		$sql = "SELECT * FROM categorias";
		$data = $this->selectall($sql);
		return $data;
	}

	//creamos la funcion de resgistro donde indicamos que recibimos ()
	public function registrarCategoria(string $nombre)
	{
		//acedemos a las var e igualamos el parametro
		$this->nombre= $nombre;

		//verificamos que no tengamos otro mismo cliente
		$verificar = "SELECT * FROM categorias WHERE nombre ='$this->nombre'";
		$exite = $this->select($verificar);
		if(empty($exite)){
			// si no existe realizamos la isercion
			$sql = "INSERT INTO categorias(nombre) VALUES (?)";
			$datos = array($this->nombre);

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
	public function editarCategoria(int $id)
    {
        $sql = "SELECT * FROM categorias WHERE id = $id";
        $data = $this->select($sql);
        return $data;
	}
	
	//creamos la funcion de modificar donde indicamos que recibimos ()
	public function modificarCategoria(string $nombre, int $id)
    {
		//acedemos a las var e igualamos el parametro
        $this->nombre = $nombre;
        $this->id = $id;

        $sql = "UPDATE categorias SET nombre = ? WHERE id = ?";
        $datos = array($this->nombre, $this->id);

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

	//eliminamos caja y reactivamos (desavilitar)
	public function accionCategoria(int $estado, int $id)
	{
		$this->id = $id;
		$this->estado = $estado;
		$sql = "UPDATE categorias SET estado = ? WHERE id = ?";
		$datos =array($this->estado, $this->id);
		$data =$this->save($sql, $datos);
		return $data;
	}

}


?>