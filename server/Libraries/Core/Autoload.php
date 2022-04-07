<?php

    // Autoload, recibe el controlador e instancia su clase para pasrala como parametro para requerirla
    spl_autoload_register(function($class){
        if (file_exists("../Libraries/".'Core/'.$class.".php")) {
            require_once("../Libraries/".'Core/'.$class.".php");
        }
    });
    
?>