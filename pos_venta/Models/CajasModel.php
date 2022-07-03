<?php

class CajasModel extends Query{

	//las variables de la funcion de registro Clientes la ponemos privado
	private  $nombre, $id, $estado;

	public function __construct()
	{
		parent::__construct();
	}

	//para optener la lista de MEdidas
	public function getCajas()
	{
		//$sql = "SELECT * FROM medidas";
		$sql = "SELECT * FROM caja";
		$data = $this->selectall($sql);
		return $data;
	}

	//creamos la funcion de resgistro donde indicamos que recibimos ()
	public function registrarCaja(string $caja)
	{
		//acedemos a las var e igualamos el parametro
		$this->caja= $caja;

		//verificamos que no tengamos otro mismo cliente
		$verificar = "SELECT * FROM caja WHERE caja ='$this->caja'";
		$exite = $this->select($verificar);
		if(empty($exite)){
			// si no existe realizamos la isercion
			$sql = "INSERT INTO caja(caja) VALUES (?)";
			$datos = array($this->caja);

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
	public function editarCaja(int $id)
    {
        $sql = "SELECT * FROM caja WHERE id = $id";
        $data = $this->select($sql);
        return $data;
	}
	
	//creamos la funcion de modificar donde indicamos que recibimos ()
	public function modificarCaja(string $caja, int $id)
    {
		//acedemos a las var e igualamos el parametro
        $this->caja = $caja;
        $this->id = $id;

        $sql = "UPDATE caja SET caja = ? WHERE id = ?";
        $datos = array($this->caja, $this->id);

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
	public function accionCaja(int $estado, int $id)
	{
		$this->id = $id;
		$this->estado = $estado;
		$sql = "UPDATE caja SET estado = ? WHERE id = ?";
		$datos =array($this->estado, $this->id);
		$data =$this->save($sql, $datos);
		return $data;
	}

}


?>