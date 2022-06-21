
<?php
//
spl_autoload_register(function($class){
    //si exite el archivo lo vamos arequerir
    if (file_exists("Config/App/".$class.".php")) {
        require_once "Config/App/" . $class . ".php";
    }
})
?>