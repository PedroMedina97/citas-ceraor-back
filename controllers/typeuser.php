<?php

use Classes\TypeUser;
use Classes\Controller;
use Classes\Auth;
use Classes\Permission;
use Classes\HTTPStatus;

$controller = new Controller();
$instance = new TypeUser();
$name_table = "typesusers";
$auth = new Auth();


/* $token = isset(getallheaders()['Authorization']) ? getallheaders()['Authorization'] : null;
$decoded = !is_null($token) ? $auth->verifyToken($token) : null;

if (!is_null($token) && !is_bool($permissions) && !is_null($decoded)) {
    $permissions = $auth->searchPermissions($decoded->permissions, "permission");
} else {
    HTTPStatus::setStatus(401);
    $message = HTTPStatus::getMessage(401);
    $response = array(
        "status" => false,
        "msg" => $message
    );
    echo json_encode($response);
    die();
} */

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
       /*  if (!empty($permissions[0])) { */
            $controller->get($instance, $name_table);
       /*  } else {
            HTTPStatus::setStatus(401);
            $message = HTTPStatus::getMessage(401);
            $response = [
                "status" => false,
                "msg" => $message
            ];
            echo json_encode($response);
        } */
        break;

    case 'POST':
       /*  if (!empty($permissions[1])) { */
            $controller->post($instance, $name_table, $body);
            
        /* } else {
            HTTPStatus::setStatus(401);
            $message = HTTPStatus::getMessage(401);
            $response = [
                "status" => false,
                "msg" => $message
            ];
            echo json_encode($response);
        }
         */
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