<?php
class Query extends Conexion{
	private $pdo, $con, $sql;

	public function __construct(){
		$this->pdo = new Conexion();
		$this->con = $this->pdo->conect();
	}

	public function select(string $sql){
		$this->sql = $sql;
		$resul= $this->con->prepare($this->sql);
		$resul->execute();
		$data= $resul->fetch(PDO::FETCH_ASSOC);
		return $data;
	}

	//seleccion de todos los usuarios
	public function selectAll(string $sql){
		$this->sql = $sql;
		$resul= $this->con->prepare($this->sql);
		$resul->execute();
		$data= $resul->fetchall(PDO::FETCH_ASSOC);
		return $data;
	}
}
?>