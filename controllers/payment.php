<?php

require 'includes/headers.php';

use Classes\Controller;
use Classes\Auth;
use Classes\HTTPStatus;
use Classes\Payment;
use Classes\Router;
use Utils\Key;

$controller = new Controller();
$instance = new Payment();
$auth = new Auth();
$router = new Router();
$name_table = "payments";
$key = new Key();

// Capturar el cuerpo de la petición
$body = json_decode(file_get_contents('php://input'), true) ?? [];

$token = getallheaders()['Authorization'] ?? null;
$decoded = $token ? $auth->verifyToken($token) : null;

if (!$decoded) {
    HTTPStatus::setStatus(401);
    echo json_encode(["status" => false, "msg" => "No autorizado"]);
    exit();
}

$permissionsArray = [];
if (isset($decoded->permissions->permissions)) {
    $permissionsArray = array_map('trim', explode(',', $decoded->permissions->permissions));
}

$method = $_SERVER['REQUEST_METHOD'];
$path = $router->getMethod();

switch ($method) {
    case 'GET':
        switch ($path) {
            case 'getall':
                if (in_array('getall_cashcut', $permissionsArray)) {
                    $data = $instance->getAllPayments();
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
            /* case 'getpaymentbyid':
                if (in_array('getall_cashcut', $permissionsArray)) {
                    $id = $router->getParam();
                    $data = $instance->getPaymentById($id);
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
                break; */
                case 'generatePaymentTicket':
                    if ($router->getParam()) {
                        $id = $router->getParam();
                        $extra = $router->getExtra(); // Obtener parámetro extra para disposición
                        $disposition = ($extra && $extra === 'download') ? 'attachment' : 'inline';
    
                        try {
                            // Este método genera y envía directamente el PDF del ticket
                            // No retorna datos, sino que hace output directo
                            $instance->getPaymentById($id, $disposition);
                            // Si llegamos aquí, hubo un error porque generateTicket() debería hacer exit
                            HTTPStatus::setStatus(500);
                            $response = [
                                "status" => false,
                                "msg" => "Error interno generando el ticket"
                            ];
                            echo json_encode($response);
                         } catch (\Exception $e) {
                            HTTPStatus::setStatus(400);
                            $response = [
                                "status" => false,
                                "msg" => $e->getMessage()
                            ];
                            echo json_encode($response);
                        }
                    } else {
                        HTTPStatus::setStatus(404);
                        $response = [
                            "status" => false,
                            "msg" => HTTPStatus::getMessage(404)
                        ];
                        echo json_encode($response);
                    }
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
                if (in_array('create_cashcut', $permissionsArray)) {
                    HTTPStatus::setStatus(201);
                    $data = $controller->post($instance, $name_table, $body);
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