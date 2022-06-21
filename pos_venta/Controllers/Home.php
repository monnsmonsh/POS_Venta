<?php
//heredamos la clase controller
class Home extends Controller{
   
    public function index() {
        //echo "Funciona el metodo";

        //recivimos en controlador y vista
        $this->views->getView($this, "index");
    }
}

 
 
?>