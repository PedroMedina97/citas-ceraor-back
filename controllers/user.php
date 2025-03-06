<?php
include_once './includes/headers.php';

use Classes\Auth;
use Classes\User;
use Classes\Controller;
use Classes\HTTPStatus;

$controller = new Controller();
$instance = new User();
$auth = new Auth();
$name_table = "users";
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
                if (in_array('getall_user', $permissionsArray)) {
                    $data = $instance->getAll('users');
                    $response = [
                        "status" => "success",
                        "msg" => $data ? "Fila(s) o Elemento(s) encontrada(s)" : "Fila(s) o Elemento(s) no encontrada(s)",
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
                if (in_array('get_user', $permissionsArray)) {
                    $id = $router->getParam();
                    $data = $instance->getById('users', $id);
                    $response = [
                        "status" => "success",
                        "msg" => $data ? "Fila(s) o Elemento(s) encontrada(s)" : "Fila(s) o Elemento(s) no encontrada(s)",
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

            case 'getmyusers':
                if(in_array('get_user', $permissionsArray)){
                    $data = $instance->getByParentId('users', 'parent_id', $router->getParam());
                    if ($data) {
                        $response = [
                            "status" => "success",
                            "msg" => "Fila(s) o Elemento(s) encontrada(s)",
                            "data" => $data
                        ];
                    } else {
                        HTTPStatus::setStatus(404);
                        $response = [
                            "status" => false,
                            "msg" => "Fila(s) o Elemento(s) no encontrada(s)"
                        ];
                    }
                } else {
                    HTTPStatus::setStatus(401);
                    $response = [
                        "status" => false,
                        "msg" => "No autorizado"
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
                $phone = $body ['phone'];
                $related = $body ['related'];
                $data = $instance->insertUser($name, $lastname, $email, $password, $birthday, $phone, $related);
                if($data === false){
                    HTTPStatus::setStatus(403);
                    $response = [
                        "status" => "false",
                        "data" => $data,
                        "msg" => HTTPStatus::getMessage(403)
                    ];
                }else{
                    HTTPStatus::setStatus(201);
                    $response = [
                        "status" => "success",
                        "data" => $data,
                        "msg" => HTTPStatus::getMessage(201)
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
            case 'updateuser':
                $id = $router->getParam();
                if(in_array('update_user', $permissionsArray)){
                    $data = $controller->update($instance, $name_table, $body);
                    $response = [
                        "status" => "success",
                        "msg" => $data ? "Fila(s) o Elemento(s) actualizado(s)" : "Fila(s) o Elemento(s) no actualizado(s)",
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

            default:
                echo "Método no definido para esta clase";
                break;
        }
       
        break;

    case 'DELETE':
        switch($path){
            case 'deleteuser':
                if(in_array('delete_user', $permissionsArray)){
                    $data = $controller->delete($instance, $name_table);
                    $response = [
                        "status" => "success",
                        "msg" => $data ? "Fila(s) o Elemento(s) eliminado(s)" : "Fila(s) o Elemento(s) no eliminado(s)",
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
