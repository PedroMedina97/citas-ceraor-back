<?php

namespace Classes;

use Classes\Router;
use Classes\File;

class Controller
{

    public function get(object $nameClass, $name_table)
    {
        $router = new Router();
        $method = $router->getMethod();
        $parameter = $router->getParam();
        $path = "controllers/$method.php";

        if ($method && is_string($method) && method_exists($nameClass, $method) && $method !== '-' && !file_exists($path)) {
            $data = ($parameter !== null) ? $nameClass->myQuery($nameClass->$method($parameter), $method) : null;
            $response = [
                "status" => true,
                "data" => $data,
                "msg" => $data ? "Fila(s) o Elemento(s) encontrada(s)" : "Fila(s) o Elemento(s) no encontrada(s)"
            ];
        } elseif ($method == '-' && is_numeric($parameter)) {
            $data = $nameClass->getById($name_table, $parameter);
            if ($data) {
                $response = [
                    "status" => "success",
                    "data" => $data
                ];
            } else {
                http_response_code(404);
                $response = [
                    "status" => false,
                    "msg" => "Elemento(s) no encontrado(s)"
                ];
            }
        } else {
            $data = $nameClass->getAll($name_table, $parameter);
            if ($data) {
                $response = [
                    "status" => true,
                    "msg" => "Elemento(s) Encontrado(s)",
                    "data" => $data
                ];
            } else {
                http_response_code(404);
                $response = [
                    "status" => false,
                    "msg" => "Elemento(s) no encontrado(s)"
                ];
            }
        }

        http_response_code($response['status'] ? 200 : 404);
        echo json_encode($response);
    }

    public function post(object $nameClass, $name_table, $content)
    {
        if (array_key_exists('image', $content[0])) {
           /*  echo "entra";
            die(); */
            $file = new File();
            $fl = $file->read($content[0]['image']);
            /* var_dump($fl);
            die(); */
            /* unset($data['image']); */
            $content[0]['image'] = "http://localhost/api-clinix/". $fl;
        }

        $data = $nameClass->create($name_table, $content);
        $status = $data ? true : false;
        $msg = $data ? "fila(s) insertada(s) correctamente" : "Error al insertar fila(s)";
        $response = [
            "status" => $status,
            "msg" => $msg,
            "data" => $data
        ];
        http_response_code($status ? 201 : 500);
        echo json_encode($response);
    }


    public function put(object $nameClass, $name_table, $content)
    {
        $router = new Router();
        $parameter = $router->getParam();

        if (isset($content['image']) && isset($content['image']['tmp_name'])) {
            $file = new File();
            $base64_image = $file->read($content['image']['tmp_name'], $content['image']['type']);
            $content['image'] = $base64_image;
        }

        $data = $parameter ? $nameClass->update($name_table, $content, $parameter) : null;
        $status = $data ? true : false;
        $msg = $data ? "Actualizado correctamente" : "Error al actualizar fila(s)";
        $response = [
            "status" => $status ? "success" : "error",
            "msg" => $msg,
            "file" => $status ? true : false
        ];
        http_response_code($status ? 200 : 400);
        echo json_encode($response);
    }


    public function delete(object $nameClass, $name_table)
    {
        $router = new Router();
        $parameter = $router->getParam();
        $data = $parameter ? $nameClass->delete($name_table, $parameter) : null;
        $status = $data ? true : false;
        $msg = $status ? "Eliminado Correctamente" : "No se pudo eliminar fila(s)";
        $response = [
            "status" => $status ? "success" : "error",
            "msg" => $msg
        ];
        http_response_code($status ? 200 : 400);
        echo json_encode($response);
    }
}
