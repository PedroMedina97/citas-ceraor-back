<?php
use Classes\Controller;
use Classes\Auth;
use Classes\HTTPStatus;
use Classes\Catalog;
/* $controller = new Controller(); */
$instance = new Catalog();
$auth = new Auth();
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

// Verificar si la ruta es diferente de "login" y "getsubsidiaries"
if ($path !== 'login' && $path !== 'getsubsidiaries') {
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
                $table = $router->getParam();
                    $data = $instance->getCatalog($table);
                    HTTPStatus::setStatus(200);
                    $response = [
                        "status" => "success",
                        "msg" => HTTPStatus::getMessage(200),
                        "data" => $data
                    ];
             
                echo json_encode($response);
            break;
            case 'getdoctors':
                $data = $instance->getDoctors();
                HTTPStatus::setStatus(200);
                    $response = [
                        "status" => "success",
                        "msg" => HTTPStatus::getMessage(200),
                        "data" => $data
                    ];
             
                echo json_encode($response);
            break;

            case 'getServicesBySubsidiary':
                $id_subsidiary = $router->getParam();
                $data = $instance->getCatalogServicesByIdSubsidiary($id_subsidiary);
                HTTPStatus::setStatus(200);
                    $response = [
                        "status" => "success",
                        "msg" => HTTPStatus::getMessage(200),
                        "data" => $data
                    ];
             
                echo json_encode($response);
            break;

            case 'getPacketsBySubsidiary':
                $id_subsidiary = $router->getParam();
                $data = $instance->getPacketsByIdSubsidiary($id_subsidiary);
                HTTPStatus::setStatus(200);
                    $response = [
                        "status" => "success",
                        "msg" => HTTPStatus::getMessage(200),
                        "data" => $data
                    ];
             
                echo json_encode($response);
            break;
            case 'getsubsidiaries':
                $data = $instance->getCatalog("subsidiaries");
                HTTPStatus::setStatus(200);
                    $response = [
                        "status" => "success",
                        "msg" => HTTPStatus::getMessage(200),
                        "data" => $data
                    ];
             
                echo json_encode($response);
            break;
            case 'getclients':
                $data = $instance->getClients();
                HTTPStatus::setStatus(200);
                    $response = [
                        "status" => "success",
                        "msg" => HTTPStatus::getMessage(200),
                        "data" => $data
                    ];
             
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

   

    default:
        HTTPStatus::setStatus(405);
        $response = [
            "status" => false,
            "msg" => HTTPStatus::getMessage(405)
        ];
        echo json_encode($response);
        break;
}