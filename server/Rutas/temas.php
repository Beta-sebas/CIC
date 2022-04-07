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
        
        $intIdTema = intval($_GET['id']);

        if ($intIdTema > 0) {
            
            $sql = "SELECT * FROM temas WHERE idtema = $intIdTema";
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

        $sql = "SELECT idtema, nombre, descripcion, DATE_FORMAT(datecreated, '%d-%m-%Y') as fechaRegistro, status FROM temas ";
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
    
    
    if (empty($data['nombre'])) {
                    
        $arrResponse = array('status' => false, 'msg' => 'Datos incorrectos.');
    }else{
        
        $intTemaId = intval($data['temaid']);
        $strNombre =  ucwords(strClean($data['nombre']));
        $strDescripcion = ucfirst(strClean($data['descripcion']));
        $intStatus = intval($data['status']);
            
        $query_insert  = "INSERT INTO temas(
            nombre,descripcion,status) VALUES(?,?,?)";
        $arrData = array($strNombre, $strDescripcion, $intStatus);
        $request_insert = $rest->insert($query_insert,$arrData);
         
        if ($request_insert > 0) { 
            
            $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');  
        }else{
            $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
        }
    }
    //header("HTTP/1.1 200 OK");
    http_response_code(200);
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    if (isset($_GET['id'])) {
        
        $intIdTema = intval($_GET['id']);

        if ($intIdTema > 0) {

            $input = file_get_contents('php://input');
            $data = json_decode($input, true);
            
            //parse_str(file_get_contents("php://input"),$put_vars);

            $intTemaId = intval($data['temaid']);
            $strNombre =  ucwords(strClean($data['nombre']));
            $strDescripcion = ucfirst(strClean($data['descripcion']));
            $intStatus = intval($data['status']);

            $query_update  = "UPDATE cursos SET
                nombre=?,descripcion=?,status=? WHERE idtema = $intIdTema";
            $arrData = array($strNombre, $strDescripcion, $intStatus);
            $request_update = $rest->update($query_update,$arrData);
            
            if ($request_update > 0) { 
            
                $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');  
            }else{
                $arrResponse = array("status" => false, "msg" => 'No es posible actualizar los datos.');
            }
        }
        
    }else {
        $arrResponse = array('status' => false, 'msg' => 'Datos incorrectos.');
    }
    header("HTTP/1.1 200 OK");
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
    exit();
}

else {
    header("HTTP/1.1 400 Bad Request");
    exit();
}








?>