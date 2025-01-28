<?php
include_once './includes/headers.php';

use Classes\Auth;
use Classes\User;
use Classes\Controller;
use Classes\HTTPStatus;
use Classes\Permission;

$controller = new Controller();
$instance = new User();
$auth = new Auth();
$name_table = "users";
$response = null;

// Obtener el token del encabezado Authorization
$token = isset(getallheaders()['Authorization']) ? getallheaders()['Authorization'] : null;

// Decodificar el token si existe
$decoded = !is_null($token) ? $auth->verifyToken($token) : null;

// Ruta y método de la solicitud
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

// Lógica principal del controlador
switch ($method) {
    case 'GET':
        if (!is_null($token) && !is_null($decoded)) {
            if (!empty($getallUserPermissions) && in_array("getall_user", $getallUserPermissions)) {
                $controller->get($instance, $name_table);
            } elseif (!empty($getUserPermissions) && in_array("get_user", $getUserPermissions)) {
                $id = isset($router) ? $router->getParam() : null;
                if ($id) {
                    $data = $instance->getUsersbyParentId($id);
                    if ($data) {
                        HTTPStatus::setStatus(200);
                        $response = [
                            "status" => true,
                            "data" => $data,
                            "msg" => HTTPStatus::getMessage(200)
                        ];
                    } else {
                        HTTPStatus::setStatus(404);
                        $response = [
                            "status" => false,
                            "msg" => HTTPStatus::getMessage(404)
                        ];
                    }
                } else {
                    HTTPStatus::setStatus(400);
                    $response = [
                        "status" => false,
                        "msg" => "Parent ID is required for get_user permission"
                    ];
                }
                echo json_encode($response);
            } else {
                HTTPStatus::setStatus(403);
                $response = [
                    "status" => false,
                    "msg" => "Permission denied"
                ];
                echo json_encode($response);
            }
        }
        break;

    case 'POST':
        switch ($path) {
            case 'login':
                $email = $body['email'];
                $password = $body['password'];
                $data = $instance->login($email, $password);
                if ($data) {
                    $response = [
                        "status" => "success",
                        "email" => $email,
                        "token" => $data['token']
                    ];
                } else {
                    HTTPStatus::setStatus(401);
                    $response = [
                        "status" => "false",
                        "msg" => "Credenciales no válidas"
                    ];
                }
                echo json_encode($response);
                break;

            case 'register':
                $name = $body['name'];
                $lastname = $body['lastname'];
                $email = $body['email'];
                $password = $body['password'];
                $birthday = $body['birthday'];
                $data = $instance->insertUser($name, $lastname, $email, $password, $birthday);
                HTTPStatus::setStatus($data ? 201 : 404);
                $response = [
                    "status" => (bool)$data,
                    "data" => $data,
                    "msg" => HTTPStatus::getMessage(HTTPStatus::getMessage($data ? 201 : 404))
                ];
                echo json_encode($response);
                break;

            default:
                echo "Método no definido para esta clase";
                break;
        }
        break;

    case 'PUT':
        $controller->put($instance, $name_table, $body);
        break;

    case 'DELETE':
        $controller->delete($instance, $name_table);
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
