<?php
	//creamos la ruta
    $ruta = !empty($_GET['url']) ? $_GET['url'] : "Home/index";
    //convertimos la ruta en areglo
    $array = explode("/", $ruta);
    $controller = $array[0];
    //var metodo index
    $metodo = "index";
    //var metodo 
    $parametro = "";

    //validamos si exite el metodo
    if (!empty($array[1])) {
    	//validamos que el campo sea diferente de vacio
        if (!empty($array[1] != "")) {
        	//si es dif lo almacenamos en metodo $array[1]
            $metodo = $array[1];
        }
    }
    
    //validamos si exite el parametro
    if (!empty($array[2])) {
    	//validamos que el campo sea diferente de vacio
        if (!empty($array[2] != "")) {
        	//si es diferente lo recoremos la cant del arreglo
            for ($i=2; $i < count($array); $i++) { 
            	//lo almacenamos en parametro $array[$i]
                $parametro .= $array[$i]. ",";
            }
            //eliminamos el ultimo caracter de parametro
            $parametro = trim($parametro, ",");
        }
    }
//Ruta de los controladores
    // validaciones para indicarle la ruta donde se encuentran los controladores, luego hacer la instancia de la clase

    $dirControllers = "Controllers/" . $controller . ".php";
	if (file_exists($dirControllers)) {
	    require_once $dirControllers;
	    $controller = new $controller();
	    if (method_exists($controller, $metodo)) {
	        $controller->$metodo($parametro);
	    } else {
	        echo 'No existe el metodo';
	    }
	} else {
	    echo 'No existe el controlador';
	}


?>