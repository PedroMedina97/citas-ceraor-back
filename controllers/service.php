<?php
use Classes\Controller;
use Classes\Auth;
use Classes\HTTPStatus;
use Classes\Service;

$controller = new Controller();
$instance = new Service();
$name_table = "services";
$auth = new Auth();

$token = isset(getallheaders()['Authorization']) ? getallheaders()['Authorization'] : null;
$decoded = !is_null($token) ? $auth->verifyToken($token) : null;

/* if (!is_null($token) && !is_bool($permissions) && !is_null($decoded)) {
    $permissions = $auth->searchPermissions($decoded->permissions, "department");
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
        switch ($router->getMethod()) {
            case 'serviceByIdUser':
                $id = $router->getParam();
                $data = $instance->getServiceByIdUser($id);
                $response = array(
                    "status" => "success",
                    "msg" => $data ? "Fila(s) o Elemento(s) encontrada(s)" : "Fila(s) o Elemento(s) no encontrada(s)",
                    "data" => $data
                );
                echo json_encode($response);
                break;

            default:
                $controller->get($instance, $name_table);
        }
    break;

    case 'POST':
       /*  if ($userType == 5) {
            HTTPStatus::setStatus(401);
            $message = HTTPStatus::getMessage(401);
            $response = [
                "status" => false,
                "msg" => $message
            ];
            echo json_encode($response);
        } else { */
            $controller->post($instance, $name_table, $body);
        /* } */
        break;

    case 'PUT':
        if ($userType == 5) {
            HTTPStatus::setStatus(401);
            $message = HTTPStatus::getMessage(401);
            $response = [
                "status" => false,
                "msg" => $message
            ];
            echo json_encode($response);
        } else {
            $controller->put($instance, $name_table, $body);
        }
        break;

    case 'DELETE':
        if ($userType == 5 || $userType == 4) {
            HTTPStatus::setStatus(401);
            $message = HTTPStatus::getMessage(401);
            $response = [
                "status" => false,
                "msg" => $message
            ];
            echo json_encode($response);
        } else {
            $data = $controller->delete($instance, $name_table);
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