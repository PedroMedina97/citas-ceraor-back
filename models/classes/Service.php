<?php

namespace Classes;

use Abstracts\Entity;
use Utils\Helpers;

class Service extends Entity{

    public function getAll(string $name_table, string $data = null){
        $query = "SELECT 
                    s.id, 
                    s.name, 
                    s.id_category,
                    c.name as category_name,
                    s.description, 
                    s.image,
                    s.active,
                    s.created_at,
                    s.updated_at
                  FROM services s
                  LEFT JOIN categories c ON s.id_category = c.id
                  WHERE s.active = 1
                  ORDER BY s.name";
        return Helpers::myQuery($query);
    }

    public function getById(string $name_table, string $id){
        $query = "SELECT 
                    s.id, 
                    s.name, 
                    s.id_category,
                    c.name as category_name,
                    s.description, 
                    s.image,
                    s.active,
                    s.created_at,
                    s.updated_at
                  FROM services s
                  LEFT JOIN categories c ON s.id_category = c.id
                  WHERE s.id = '$id'";
        $result = Helpers::myQuery($query);
        return $result ? $result[0] : null;
    }

    public function getServiceByIdSubsidiary(String $name_table, String $id){
        return Helpers::getByIdRelated($name_table, "subsidiary", $id);
    }

     public function getServicesSubsidiary(string $id_subsidiary){
        $query = "SELECT 
                    s.id, 
                    s.name, 
                    s.id_category,
                    c.name as category_name,
                    s.description, 
                    s.image,
                    ss.price, 
                    s.active 
                  FROM services s
                  INNER JOIN subsidiaries_services ss ON s.id = ss.id_service
                  LEFT JOIN categories c ON s.id_category = c.id
                  WHERE ss.id_subsidiary = '$id_subsidiary' AND s.active = 1
                  ORDER BY s.name";
        return Helpers::myQuery($query);
    }
}