<?php

class MedidasModel extends Query{

	//las variables de la funcion de registro Clientes la ponemos privado
	private  $nombre, $nombre_corto, $id, $estado;

	public function __construct()
	{
		parent::__construct();
	}

	//para optener la lista de MEdidas
	public function getMedidas()
	{
		//$sql = "SELECT * FROM medidas";
		$sql = "SELECT * FROM Medidas";
		$data = $this->selectall($sql);
		return $data;
	}

	//creamos la funcion de resgistro donde indicamos que recibimos ()
	public function registrarMedida(string $nombre,string $nombre_corto)
	{
		//acedemos a las var e igualamos el parametro
		$this->nombre= $nombre;
		$this->nombre_corto= $nombre_corto;

		//verificamos que no tengamos otro mismo cliente
		$verificar = "SELECT * FROM medidas WHERE nombre ='$this->nombre'";
		$exite = $this->select($verificar);
		if(empty($exite)){
			// si no existe realizamos la isercion
			$sql = "INSERT INTO medidas(nombre, nombre_corto) VALUES (?,?)";
			$datos = array($this->nombre, $this->nombre_corto);

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
	public function editarMedida(int $id)
    {
        $sql = "SELECT * FROM medidas WHERE id = $id";
        $data = $this->select($sql);
        return $data;
	}
	
	//creamos la funcion de modificar donde indicamos que recibimos ()
	public function modificarMedida(string $nombre, string $nombre_corto, int $id)
    {
		//acedemos a las var e igualamos el parametro
        $this->nombre = $nombre;
        $this->nombre_corto = $nombre_corto;
        $this->id = $id;

        $sql = "UPDATE medidas SET nombre = ?, nombre_corto = ?  WHERE id = ?";
        $datos = array($this->nombre, $this->nombre_corto, $this->id);

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
	public function accionMedida(int $estado, int $id)
	{
		$this->id = $id;
		$this->estado = $estado;
		$sql = "UPDATE medidas SET estado = ? WHERE id = ?";
		$datos =array($this->estado, $this->id);
		$data =$this->save($sql, $datos);
		return $data;
	}

}


?>