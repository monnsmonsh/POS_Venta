<?php
//heredamos la clase controller
class Home extends Controller{
    
    //Para que la seccion funcione debe inicializarlo dentro de contructor
    public function __construct() 
    {
        //iniciamos seccion
        session_start();
        if (!empty($_SESSION['activo'])) {
            header("location: ".base_url."Usuarios");
        }
        //cargamos el constructor de la instancia
        parent::__construct();
    }
   
    public function index() {
        //echo "Funciona el metodo";

        //recivimos en controlador y vista
        $this->views->getView($this, "index");
    }
}

 
 
?>