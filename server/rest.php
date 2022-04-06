<?php 

require_once("Config/Config.php");
require_once("Helpers/Helpers.php");
require_once("Libraries/Core/Autoload.php");

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

$rest = new Mysql();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['id'])) {
        
        $intIdCurso = intval($_GET['id']);

        if ($intIdCurso > 0) {
            
            $sql = "SELECT c.idcurso,c.temaid,c.personaid,c.codigo,c.nombre,c.descripcion,p.nombre as nombretutor,p.apellidos,c.status, DATE_FORMAT(c.datecreated, '%d-%m-%Y') as fechaRegistro 
					FROM cursos c
					INNER JOIN personas p
					ON c.personaid = p.rolid
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
					ON c.personaid = p.rolid ";
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
    
    if (empty($_POST['txtCodigo']) || empty($_POST['txtNombre'])) {
                    
        $arrResponse = array('status' => false, 'msg' => 'Datos incorrectos.');
    }else{
        
        $intTemaId = intval($_POST['listTema']);
        $intPersonaId = intval($_POST['listTutor']);
        $strCodigo = strClean($_POST['txtCodigo']);
        $strNombre =  strClean($_POST['txtNombre']);
        $strDescripcion = strClean($_POST['txtDescripcion']);
        $intStatus = intval($_POST['listStatus']);
            
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
    header("HTTP/1.1 200 OK");
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    if (isset($_GET['id'])) {
        
        $intIdCurso = intval($_GET['id']);

        if ($intIdCurso > 0) {
            
            parse_str(file_get_contents("php://input"),$put_vars);

            $intTemaId = intval($put_vars['listTema']);
            $intPersonaId = intval($put_vars['listTutor']);
            $strCodigo = strClean($put_vars['txtCodigo']);
            $strNombre =  strClean($put_vars['txtNombre']);
            $strDescripcion = strClean($put_vars['txtDescripcion']);
            $intStatus = intval($put_vars['listStatus']);

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

    //parse_str(file_get_contents("php://input"),$put_vars);
    //echo json_encode($put_vars,JSON_UNESCAPED_UNICODE);
    //dep($put_vars);
    //die();

header("HTTP/1.1 400 Bad Request");







?>