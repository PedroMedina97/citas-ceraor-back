<?php

use Classes\Controller;
use Classes\Auth;
use Classes\HTTPStatus;
use Classes\File;

$controller = new Controller();
$auth = new Auth();
$response = null;
$method = $_SERVER['REQUEST_METHOD'];
$path = isset($router) ? $router->getMethod() : null;
/* echo "entra";
die(); */
switch ($method) {
    case 'GET':
        switch ($path) {
            case 'getfile':
                $directory = "C:/wamp64/www/citas-ceraor-back/docs/";
                $filePath = $directory . "orden.pdf"; 

                if (!is_dir($directory)) {
                    echo json_encode(["error" => "La carpeta no existe"]);
                    exit;
                }

                if ($param === 'list') {
                    $files = scandir($directory);
                    $files = array_diff($files, ['.', '..']);
                    echo json_encode(["files" => array_values($files)]);
                    exit;
                }

                if ($param === 'read') {
                    if (file_exists($filePath)) {
                        echo json_encode(["content" => file_get_contents($filePath)]);
                    } else {
                        echo json_encode(["error" => "El archivo test.txt no existe"]);
                    }
                    exit;
                }

                // Descargar el archivo
                if ($param === 'download') {
                    if (file_exists($filePath)) {
                        // Configurar los encabezados para la descarga
                        header('Content-Description: File Transfer');
                        header('Content-Type: application/octet-stream');
                        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate');
                        header('Pragma: public');
                        header('Content-Length: ' . filesize($filePath));

                        // Leer y enviar el archivo al cliente
                        readfile($filePath);
                        exit;
                    } else {
                        echo json_encode(["error" => "El archivo test.txt no existe"]);
                    }
                    exit;
                }

                echo json_encode(["error" => "Acción no válida"]);
                exit;

            default:
                HTTPStatus::setStatus(404);
                echo json_encode([
                    "status" => false,
                    "msg" => HTTPStatus::getMessage(404)
                ]);
                break;
        }
        break;

    default:
        HTTPStatus::setStatus(405);
        echo json_encode([
            "status" => false,
            "msg" => HTTPStatus::getMessage(405)
        ]);
        break;
}
