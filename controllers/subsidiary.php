<?php
include_once './includes/headers.php';

use Classes\Auth;
use Classes\Subsidiary;
use Classes\Controller;
use Classes\HTTPStatus;

$controller = new Controller();
$instance = new Subsidiary();
$auth = new Auth();
$name_table = "subsidiaries";
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
                if (in_array('getall_subsidiary', $permissionsArray)) {
                    $data = $instance->getAll($name_table);
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

            case 'getbyid':
                if (in_array('get_subsidiary', $permissionsArray)) {
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

            case 'getservices':
                if (in_array('get_subsidiary', $permissionsArray)) {
                    $id = $router->getParam();
                    $data = $instance->getServicesSubsidiary($id);
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

            case 'getpackets':
                if (in_array('get_subsidiary', $permissionsArray)) {
                    $id = $router->getParam();
                    $data = $instance->getPacketsSubsidiary($id);
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

            case 'getallservices':
                if (in_array('get_subsidiary', $permissionsArray) || in_array('getall_service', $permissionsArray)) {
                    $data = $instance->getAllServices();
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
                if(in_array('create_subsidiary', $permissionsArray)){
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
                if(in_array('update_subsidiary', $permissionsArray)){
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
                if(in_array('update_subsidiary', $permissionsArray)){
                    $id = $router->getParam();
                    
                    if($id && isset($body['services']) && is_array($body['services'])){
                        // Validar que cada servicio tenga id_service y price
                        $valid = true;
                        foreach($body['services'] as $service){
                            if(!isset($service['id_service']) || !isset($service['price'])){
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
                                "msg" => "Cada servicio debe contener id_service y price"
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

            case 'setpackets':
                if(in_array('update_subsidiary', $permissionsArray)){
                    $id = $router->getParam();
                    
                    if($id && isset($body['packets']) && is_array($body['packets'])){
                        // Validar que cada paquete tenga id_packet y price
                        $valid = true;
                        foreach($body['packets'] as $packet){
                            if(!isset($packet['id_packet']) || !isset($packet['price'])){
                                $valid = false;
                                break;
                            }
                        }
                        
                        if($valid){
                            $result = $instance->setPackets($id, $body['packets']);
                            
                            if($result['success']){
                                HTTPStatus::setStatus(200);
                                $response = [
                                    "status" => "success",
                                    "msg" => "Paquetes actualizados correctamente",
                                    "data" => $result
                                ];
                            } else {
                                HTTPStatus::setStatus(500);
                                $response = [
                                    "status" => false,
                                    "msg" => "Error al actualizar paquetes",
                                    "error" => $result['error']
                                ];
                            }
                        } else {
                            HTTPStatus::setStatus(400);
                            $response = [
                                "status" => false,
                                "msg" => "Cada paquete debe contener id_packet y price"
                            ];
                        }
                    } else {
                        HTTPStatus::setStatus(400);
                        $response = [
                            "status" => false,
                            "msg" => "Parámetros inválidos. Se requiere id en la URL y packets (array) en el body"
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
                if(in_array('delete_subsidiary', $permissionsArray)){
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