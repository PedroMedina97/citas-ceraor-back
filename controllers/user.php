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
$token == null;


/* $token = isset(getallheaders()['Authorization']) ? getallheaders()['Authorization'] : null;

$decoded = !is_null($token) ? $auth->verifyToken($token) : null;
var_dump($decoded);
die(); */




switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        echo ("entra");
         if (!is_null($token) && !is_null($decoded)) {
            if (!empty($getallUserPermissions) && in_array("getall_user", $getallUserPermissions)) {
                $controller->get($instance, $name_table);
            } elseif (!empty($getUserPermissions) && in_array("get_user", $getUserPermissions)) {
                $id = isset($router) ? $router->getParam() : null; // Assuming the ID comes from router parameters
                if ($id) {
                    $data = $instance->getUsersbyParentId($id);
                    if ($data) { 
                        HTTPStatus::setStatus(200);
                        $message = HTTPStatus::getMessage(200);
                        $response = [
                            "status" => true,
                            "data" => $data,
                            "msg" => $message
                        ];
                    } else {
                        HTTPStatus::setStatus(404);
                        $message = HTTPStatus::getMessage(404);
                        $response = [
                            "status" => false,
                            "msg" => $message
                        ];
                    }
                    echo json_encode($response);
                } else {
                    HTTPStatus::setStatus(400);
                    $message = HTTPStatus::getMessage(400);
                    $response = [
                        "status" => false,
                        "msg" => "Parent ID is required for get_user permission"
                    ];
                    echo json_encode($response);
                }
            } else {
                HTTPStatus::setStatus(403);
                $message = HTTPStatus::getMessage(403);
                $response = [
                    "status" => false,
                    "msg" => "Permission denied"
                ];
                echo json_encode($response);
            }
        } else {
            HTTPStatus::setStatus(401);
            $message = HTTPStatus::getMessage(401);
            $response = [
                "status" => false,
                "msg" => $message
            ];
            echo json_encode($response);
        }
        break;

    case 'POST':
        switch ($router->getMethod()) {
            case 'login':
                $email = $body['email'];
                $password = $body['password'];
                $data = $instance->login($email, $password);
                if ($data) {
                    $response = array(
                        "status" => "success",
                        "email" => $email,
                        "token" => $data['token']
                    );
                    echo json_encode($response);
                } else {
                    HTTPStatus::setStatus(401);
                    $response = array(
                        "status" => "false",
                        "msg" => "Credenciales no Válidas",
                        "token" => $data
                    );
                    echo json_encode($response);
                }
                break;

            case 'register':
                /* var_dump($body);
                    die(); */
                $name = $body['name'];
                $lastname = $body['lastname'];
                $email = $body['email'];
                $password = $body['password'];
                $birthday = $body['birthday'];
                $data = $instance->insertUser($name, $lastname, $email, $password,  $birthday);
                /* var_dump($data);
                die(); */
                if ($data) {
                    HTTPStatus::setStatus(201);
                    $message = HTTPStatus::getMessage(201);
                    $response = [
                        "status" => true,
                        "data" => $data,
                        "msg" => $message
                    ];
                    /*  echo json_encode($response); */
                } else {
                    HTTPStatus::setStatus(404);
                    $message = HTTPStatus::getMessage(404);
                    $response = [
                        "status" => true,
                        "data" => $data,
                        "msg" => $message
                    ];
                    /*  echo json_encode($response); */
                }
                echo json_encode($response);
                break;


            case 'createUser':
                $parent_id = $body['parent_id'];
                $name = $body['name'];
                $lastname = $body['lastname'];
                $email = $body['email'];
                $password = $body['password'];
                $birthday = $body['birthday'];
                $data = $instance->createUser($parent_id, $name, $lastname, $email, $password, $birthday);
                if ($data) {
                    HTTPStatus::setStatus(201);
                    $message = HTTPStatus::getMessage(201);
                    $response = [
                        "status" => true,
                        "data" => $data,
                        "msg" => $message
                    ];
                } else {
                    HTTPStatus::setStatus(406);
                    $message = HTTPStatus::getMessage(406);
                    $response = [
                        "status" => false,
                        "data" => $data,
                        "msg" => $message
                    ];
                }
                echo json_encode($response);

                break;
            default:
                "Método no definido para esta clase";
        }
        break;

    case 'PUT':
        if (!empty($permissions[2])) {
            $controller->put($instance, $name_table, $body);
        } else {
            HTTPStatus::setStatus(401);
            $message = HTTPStatus::getMessage(401);
            $response = [
                "status" => false,
                "msg" => $message
            ];
            echo json_encode($response);
        }
        break;

    case 'DELETE':
        if (!empty($permissions[3])) {
            $data = $controller->delete($instance, $name_table);
        } else {
            $data = $controller->delete($instance, $name_table);
            HTTPStatus::setStatus(401);
            $message = HTTPStatus::getMessage(401);
            $response = [
                "status" => false,
                "msg" => $message
            ];
            echo json_encode($response);
        }
        break;

    default:
        HTTPStatus::setStatus(405);
        $message = HTTPStatus::getMessage(405);
        $response = [
            "status" => false,
            "msg" => $message
        ];
        echo json_encode($response);
        break;
}
