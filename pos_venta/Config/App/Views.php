<?php
//
class Views{
	public function getView($controlador, $vista){
		$controlador = get_class($controlador);
		//Validamos si el controlador es igual HOME
		if($controlador =="Home"){
			//si es igual indicamos a que vista acedera
			$vista = "views/".$vista.".php";
		}else{
			$vista = "views/".$controlador."/".$vista."php";
		}
		require $vista;
	}
}
?>
