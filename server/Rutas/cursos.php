<?php 

include "../Config/Config.php";
require_once("../Helpers/Helpers.php");
require_once("../Libraries/Core/Autoload.php");


$rest = new Mysql();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['id'])) {
        
        $intIdCurso = intval($_GET['id']);

        if ($intIdCurso > 0) {
            
            $sql = "SELECT c.idcurso,c.temaid,c.personaid,c.codigo,c.nombre,c.descripcion,p.nombre as nombretutor,p.apellidos,c.status, DATE_FORMAT(c.datecreated, '%d-%m-%Y') as fechaRegistro 
					FROM cursos c
					INNER JOIN personas p
					ON c.personaid=p.id
					WHERE c.idcurso = $intIdCurso";
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

        $sql = "SELECT c.idcurso,c.temaid,c.personaid,c.codigo,c.nombre,c.descripcion,p.nombre as nombretutor,p.apellidos,c.status, DATE_FORMAT(c.datecreated, '%d-%m-%Y') as fechaRegistro 
					FROM cursos c
					INNER JOIN personas p
					ON c.personaid = p.id WHERE c.status = 1 ORDER BY c.idcurso";
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
    
    
    if (empty($data['codigo']) || empty($data['nombre'])) {
                    
        $arrResponse = array('status' => false, 'msg' => 'Datos incorrectos.');
    }else{
        
        $intTemaId = intval($data['temaid']);
        $intPersonaId = intval($data['personaid']);
        $strCodigo = strClean($data['codigo']);
        $strNombre =  strClean($data['nombre']);
        $strDescripcion = strClean($data['descripcion']);
        $intStatus = intval($data['status']);
            
        $query_insert  = "INSERT INTO cursos(
            temaid,personaid,codigo,nombre,descripcion,status) VALUES(?,?,?,?,?,?)";
        $arrData = array($intTemaId, $intPersonaId, $strCodigo, $strNombre, $strDescripcion, $intStatus);
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
        
        $intIdCurso = intval($_GET['id']);

        if ($intIdCurso > 0) {

            $input = file_get_contents('php://input');
            $data = json_decode($input, true);
            
            //parse_str(file_get_contents("php://input"),$put_vars);

            $intTemaId = intval($data['temaid']);
            $intPersonaId = intval($data['personaid']);
            $strCodigo = strClean($data['codigo']);
            $strNombre =  strClean($data['nombre']);
            $strDescripcion = strClean($data['descripcion']);
            $intStatus = intval($data['status']);

            $query_update  = "UPDATE cursos SET
                temaid=?,personaid=?,codigo=?,nombre=?,descripcion=?,status=? WHERE idcurso = $intIdCurso";
            $arrData = array($intTemaId, $intPersonaId, $strCodigo, $strNombre, $strDescripcion, $intStatus);
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

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    
    if (isset($_GET['id'])) {
        
        $intIdCurso = intval($_GET['id']);

        if ($intIdCurso > 0) {

            $sql= " SELECT * FROM cursos WHERE idcurso = $intIdCurso";
            $request = $rest->select($sql);
            if(empty($request))
            {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            }else{

                $sql_delete = "UPDATE cursos SET status = ? WHERE idcurso = $intIdCurso ";
                $arrData = array(0);
                $requestDelete = $rest->update($sql_delete,$arrData);
                
                if($requestDelete)
                {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el curso');
                }else{
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el curso.');
                }
            }
            
        }else {
            $arrResponse = array('status' => false, 'msg' => 'Datos incorrectos.');
        }
    }else {
        $arrResponse = array('status' => false, 'msg' => 'Datos incorrectos.');
    }
    header("HTTP/1.1 200 OK");
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
    exit();

}

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Indica los métodos permitidos.
    header('Access-Control-Allow-Methods: GET, POST, DELETE');
    // Indica los encabezados permitidos.
    header('Access-Control-Allow-Headers: Authorization');
    http_response_code(204);
}

    //parse_str(file_get_contents("php://input"),$put_vars);
    //echo json_encode($put_vars,JSON_UNESCAPED_UNICODE);
    //dep($put_vars);
    //die();

header("HTTP/1.1 400 Bad Request");







?>