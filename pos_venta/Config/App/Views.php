<?php
//
class Views{
	public function getView($controlador, $vista, $data="")
	{
		$controlador = get_class($controlador);
		//Validamos si el controlador es igual HOME
		if ($controlador == "Home") {
			//si es igual indicamos a que vista acedera
			$vista = "Views/".$vista.".php";
        }else{
            $vista = "Views/".$controlador."/".$vista.".php";
        }
        require $vista;
	}
}
?>
