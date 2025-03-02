<?php 

namespace Classes;

use Abstracts\Entity;
use Utils\Helpers;

class RolPermission extends Entity{
    
    public function getPermissionsbyIdRol(String $id){
        $data = false;
        if($id && is_string($id)){
            $id = mysqli_real_escape_string(Helpers::connect(), $id);
        $query = "SELECT 
                        p.id AS permiso_id, 
                        p.name AS permiso_nombre, 
                        p.description AS permiso_descripcion
                    FROM rols_permissions rp
                    JOIN permissions p ON rp.id_permission = p.id
                    WHERE rp.id_rol = $id;";
        /* echo $query;
        die(); */
        $results = Helpers::connect()->query($query);
        $data = $results->fetch_all(MYSQLI_ASSOC);
        }
        return $data;
    }
}