<?php

namespace Classes;

use Abstracts\Entity;
use Utils\Helpers;

class Service extends Entity{

    public function getServiceByIdUser(String $id){
        return Helpers::getByIdRelated("services", "user", $id);
    }
}