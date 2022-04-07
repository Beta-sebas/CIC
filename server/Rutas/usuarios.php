<?php 

require_once("../Config/Config.php");
require_once("../Helpers/Helpers.php");
require_once("../Libraries/Core/Autoload.php");

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

$rest = new Mysql();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['id'])) {
        
        $intIdPersona = intval($_GET['id']);

        if ($intIdPersona > 0) {
            
            $sql = "SELECT * FROM personas WHERE id = $intIdPersona";
			$request = $rest->select($sql);
            if(empty($request))
            {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            }else{
                $arrResponse = array('status' => true, 'data' => $request);
            }
            header("HTTP/1.1 200 OK");
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            exit();

        }
    }
    else {

        $sql = "SELECT * FROM personas";
        $request = $rest->select_all($sql);
        if(empty($request))
        {
            $arrResponse = array('status' => false, 'msg' => 'No hay datos para mostrar.');
        }else{
            $arrResponse = array('status' => true, 'data' => $request);
        }
        header("HTTP/1.1 200 OK");
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        exit();
        
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    header("HTTP/1.1 200 OK");
    echo json_encode("hola hice la prueba",JSON_UNESCAPED_UNICODE);


}

header("HTTP/1.1 400 Bad Request");

?>