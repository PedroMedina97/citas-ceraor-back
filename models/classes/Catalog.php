<?php

namespace Classes;

use Abstracts\Entity;
use Utils\Helpers;

class Catalog extends Entity{

    public function getCatalog(String $name_table){

        $sql ="SELECT id, name FROM $name_table WHERE active=1;";
        return Helpers::myQuery($sql);
    }

    public function getDoctors(){
        $sql ="SELECT * FROM users where id_rol= 5 and active= 1";
        return Helpers::myQuery($sql);
    }

    public function getClients(){
        $sql ="SELECT * FROM users where id_rol= 6 and active= 1;";
        return Helpers::myQuery($sql);
    }
}