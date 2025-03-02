<?php

namespace Classes;

use Abstracts\Entity;
use Utils\Helpers;

class Order extends Entity{


    public function getOrdersByIdAppointment(String $name_table, String $id){
        return Helpers::getByIdRelated($name_table, "appointment", $id);
    }
}