<?php
use Classes\Controller;
use Classes\Auth;
use Classes\HTTPStatus;
use Classes\Packet;

$controller = new Controller();
$instance = new Packet();
$auth = new Auth();
$name_table = "packets";
$response = null;

// Obtener el token del encabezado Authorization
$token = isset(getallheaders()['Authorization']) ? getallheaders()['Authorization'] : null;

// Decodificar el token si existe
$decoded = !is_null($token) ? $auth->verifyToken($token) : null;

$permissionsArray = [];
if (!is_null($decoded) && isset($decoded->permissions->permissions)) {
    $permissions = $decoded->permissions->permissions;
    $permissionsArray = explode(",", $permissions);
    $permissionsArray = array_map('trim', $permissionsArray);
}

$method = $_SERVER['REQUEST_METHOD'];
$path = isset($router) ? $router->getMethod() : null;

// Verificar si la ruta es diferente de "login"
if ($path !== 'login') {
    // Si el token no existe o no es válido, regresar "401 No autorizado"
    if (is_null($token) || is_null($decoded)) {
        HTTPStatus::setStatus(401);
        $response = [
            "status" => false,
            "msg" => "No autorizado"
        ];
        echo json_encode($response);
        exit();
    }
}

switch ($method) {
    case 'GET':
        switch ($path) {
            case 'getall':
                if (in_array('getall_service', $permissionsArray)) {
                    $data = $instance->getAllPackets();
                    HTTPStatus::setStatus(200);
                    $response = [
                        "status" => "success",
                        "msg" => HTTPStatus::getMessage(200),
                        "data" => $data
                    ];
                } else {
                    HTTPStatus::setStatus(401);
                    $response = [
                        "status" => false,
                        "msg" => "No autorizado"
                    ];
                }
                echo json_encode($response);
            break;

            case 'getbypacketid':
                if (in_array('get_service', $permissionsArray)) {
                    $id = $router->getParam();
                    $data = $instance->getServicesByPacketId($id);
                    HTTPStatus::setStatus(200);
                    $response = [
                        "status" => "success",
                        "msg" => HTTPStatus::getMessage(200),
                        "data" => $data
                    ];
                } else {
                    HTTPStatus::setStatus(401);
                    $response = [
                        "status" => false,
                        "msg" => HTTPStatus::getMessage(401)
                    ];
                }
                echo json_encode($response);
            break;

            case 'getbyid':
                if (in_array('get_service', $permissionsArray)) {
                    $id = $router->getParam();
                    $data = $instance->getById($name_table, $id);
                    HTTPStatus::setStatus(200);
                    $response = [
                        "status" => "success",
                        "msg" => HTTPStatus::getMessage(200),
                        "data" => $data
                    ];
                } else {
                    HTTPStatus::setStatus(401);
                    $response = [
                        "status" => false,
                        "msg" => HTTPStatus::getMessage(401)
                    ];
                }
                echo json_encode($response);
            break;

            default:
                HTTPStatus::setStatus(404);
                $response = [
                    "status" => false,
                    "msg" => HTTPStatus::getMessage(404)
                ];
                echo json_encode($response);
            break;     
        }
        break;

    case 'POST':
        switch ($path) {
            case 'create':
                if(in_array('create_service', $permissionsArray)){
                    HTTPStatus::setStatus(201);
                    $data = $controller->post($instance, $name_table, $body);
                    $response = [
                        "status" => "success",
                        "msg" => HTTPStatus::getMessage(201),
                        "data" => $data
                    ];
                }
                else{
                    HTTPStatus::setStatus(401);
                    $response = [
                        "status" => false,
                        "msg" => HTTPStatus::getMessage(401)
                    ];
                }
                echo json_encode($response);
            break;
            default:
                echo "Método no definido para esta clase";
                break;
        }
        break;

    case 'PUT':
        switch ($path){
            case 'update':
                if(in_array('update_service', $permissionsArray)){
                    HTTPStatus::setStatus(200);
                    $data = $controller->update($instance, $name_table, $body);
                    $response = [
                        "status" => "success",
                        "msg" => HTTPStatus::getMessage(200),
                        "data" => $data
                    ];
                }
                else{
                    HTTPStatus::setStatus(401);
                    $response = [
                        "status" => false,
                        "msg" => HTTPStatus::getMessage(401)
                    ];
                }
                echo json_encode($response);
            break;

            case 'setservices':
                if(in_array('update_service', $permissionsArray)){
                    $id = $router->getParam();
                    
                    if($id && isset($body['services']) && is_array($body['services'])){
                        // Validar que cada servicio tenga id_service o sea un string
                        $valid = true;
                        foreach($body['services'] as $service){
                            if(is_array($service) && !isset($service['id_service'])){
                                $valid = false;
                                break;
                            } else if (!is_array($service) && !is_string($service)){
                                $valid = false;
                                break;
                            }
                        }
                        
                        if($valid){
                            $result = $instance->setServices($id, $body['services']);
                            
                            if($result['success']){
                                HTTPStatus::setStatus(200);
                                $response = [
                                    "status" => "success",
                                    "msg" => "Servicios actualizados correctamente",
                                    "data" => $result
                                ];
                            } else {
                                HTTPStatus::setStatus(500);
                                $response = [
                                    "status" => false,
                                    "msg" => "Error al actualizar servicios",
                                    "error" => $result['error']
                                ];
                            }
                        } else {
                            HTTPStatus::setStatus(400);
                            $response = [
                                "status" => false,
                                "msg" => "Formato inválido. Cada servicio debe ser un string (id_service) o un objeto con id_service"
                            ];
                        }
                    } else {
                        HTTPStatus::setStatus(400);
                        $response = [
                            "status" => false,
                            "msg" => "Parámetros inválidos. Se requiere id en la URL y services (array) en el body"
                        ];
                    }
                }
                else{
                    HTTPStatus::setStatus(401);
                    $response = [
                        "status" => false,
                        "msg" => HTTPStatus::getMessage(401)
                    ];
                }
                echo json_encode($response);
            break;

            default:
                echo "Método no definido para esta clase";
            break;
        }
       
        break;

    case 'DELETE':
        switch($path){
            case 'delete':
                if(in_array('delete_service', $permissionsArray)){
                    $data = $controller->delete($instance, $name_table);
                    HTTPStatus::setStatus(200);
                    $response = [
                        "status" => "success",
                        "msg" => HTTPStatus::getMessage(200),
                        "data" => $data
                    ];
                } else {
                    HTTPStatus::setStatus(401);
                    $response = [
                        "status" => false,
                        "msg" => HTTPStatus::getMessage(401)
                    ];
                }
                echo json_encode($response);
            break;

            default:
                echo "Método no definido para esta clase";
                break;
        }
        break;

    default:
        HTTPStatus::setStatus(405);
        $response = [
            "status" => false,
            "msg" => HTTPStatus::getMessage(405)
        ];
        echo json_encode($response);
        break;
}