<?php

namespace Classes;

use Abstracts\Entity;
use Utils\Helpers;

class Catalog extends Entity{

    public function getCatalog(String $name_table){

        $sql ="SELECT id, name FROM $name_table WHERE active=1;";
        return Helpers::myQuery($sql);
    }

    public function getCatalogById(String $name_table, String $id, $name_instance){
        $sql ="SELECT id, name FROM $name_table WHERE id_$name_instance= '$id' AND active=1;";
        $result = Helpers::myQuery($sql);
        return $result;
    }

    public function getDoctors(){
        $sql ="SELECT * FROM users where id_rol= 5 and active= 1";
        return Helpers::myQuery($sql);
    }

    public function getCatalogServicesByIdSubsidiary(String $id_subsidiary){
        $sql ="SELECT 
                s.id,
                s.name,
                ss.price
            FROM subsidiaries_services ss

            INNER JOIN services s 
                ON s.id = ss.id_service

            WHERE ss.id_subsidiary = '$id_subsidiary'
            AND s.active = 1

            ORDER BY s.name ASC;";
        return Helpers::myQuery($sql);
    }

    public function getPacketsByIdSubsidiary(String $id_subsidiary){
        $sql ="
                    SELECT 
                p.id AS packet_id,
                p.name AS packet_name,
                sp.price AS packet_price,

                JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'id', s.id,
                        'name', s.name
                    )
                ) AS services

            FROM subsidiaries_packets sp

            INNER JOIN packets p 
                ON p.id = sp.id_packet 
                AND p.active = 1

            INNER JOIN packets_services ps 
                ON ps.id_packet = p.id 
                AND ps.active = 1

            INNER JOIN services s 
                ON s.id = ps.id_service 
                AND s.active = 1

            WHERE sp.id_subsidiary = '$id_subsidiary'
            AND sp.active = 1

            GROUP BY 
                p.id,
                p.name,
                sp.price

            ORDER BY p.name ASC;
        ";
        return Helpers::myQuery($sql);
    }

    public function getClients(){
        $sql ="SELECT * FROM users where id_rol= 6 and active= 1;";
        return Helpers::myQuery($sql);
    }
}