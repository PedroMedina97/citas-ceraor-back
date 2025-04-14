<?php

namespace Classes;

use Classes\File;

class Router
{
    public $uri;
    public $controller;
    public $param;
    public $method;
    public $extra;

    public function __construct()
    {
        $this->setUri();
        $this->setController();
        $this->setParam();
        $this->setMethod();
        $this->setExtra();
        /*  $this->dispatch(); */
    }

    public function setUri()
    {
        $this->uri = explode('/', $_SERVER['REQUEST_URI']);
    }

    public function setController()
    {
        $this->controller = $this->uri[1] ?? 'not_found';
    }
    
    public function setMethod()
    {
        $this->method = $this->uri[2] ?? '';
    }
    
    public function setParam()
    {
        $this->param = $this->uri[3] ?? '';
    }
    
    public function setExtra()
    {
        $this->extra = $this->uri[4] ?? '';
    }
     

    public function getUri()
    {
        return $this->uri;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getParam()
    {
        return $this->param;
    }

    public function getExtra()
    {
        return $this->extra;
    }

    /* public function dispatch()
    {
        if ($this->controller === 'file' && !empty($this->method)) {
            $fileController = new File();
            $fileController->getFile($this->method);
            exit;
        }

        http_response_code(404);
        echo json_encode(["error" => "Ruta no encontrada"]);
    } */
}
