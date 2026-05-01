<?php

use Classes\Controller;
use Classes\Auth;
use Classes\HTTPStatus;
use Classes\Note;

$controller = new Controller();
$instance = new Note();
$auth = new Auth();
$name_table = "notes";
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
if ($path !== 'login' && $path !== 'generatedocument' && $path !== 'generatedocumentbycode' && $path !== 'generatedocumentbyorderid' && $path !== 'generateticket' && $path !== 'getformorder') {
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
                if (in_array('getall_order', $permissionsArray)) {
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
                if (in_array('get_order', $permissionsArray)) {
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
                if (in_array('create_order', $permissionsArray)) {
                    HTTPStatus::setStatus(201);
                    $data = $instance->create($name_table, $body);
                    $response = [
                        "status" => "success",
                        "msg" => HTTPStatus::getMessage(201),
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
