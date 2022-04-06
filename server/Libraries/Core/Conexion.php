<?php

    //Autor Juan Sebastian Betancourt 
    //jsbetancourt@unicauca.edu.co 
    //Ingeníero Eléctronico - Universidad del Cauca 

    /*Implementación de PDO (Objeto de datos PHP > v5.1) es utilizado para acceder 
    a diversas bases de datos por medio de un controlador en especifico, vamos a 
    estructurar y ejecutar instrucciones sql por medio de PDO ) */

    class Conexion{

        private $cBD; //PDO

        public function __construct(){
            $parametrosconexion= "mysql:host=".DB_HOST.";dbname=".DB_NAME.";".DB_CHARSET;
            try {
                //Objeto PDO, Permite la conexión entre PHP y la BD, recibe como paremetros "nombreHost y BD", "UsuarioBD", "passBD"
                $this->cBD = new PDO($parametrosconexion, DB_USER, DB_PASSWORD); 
                $this->cBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                echo "Error :". $e->getMessage();
            }
        }

        public function conectar(){
            return $this->cBD;
        }
        
    }

?>