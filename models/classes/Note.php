<?php

namespace Classes;
use Abstracts\Entity;
use Utils\Helpers;

class Note extends Entity
{
    public function getByIdOrderService($id_order, $id_service)
    {
        $sql = "SELECT * FROM notes WHERE id_order = '$id_order' AND id_service = '$id_service' AND active = 1";
        return Helpers::myQuery($sql);
    }   
}