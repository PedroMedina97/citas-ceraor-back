<?php


namespace Classes;
use Abstracts\Entity;
use Utils\Helpers;
use Utils\Key;

class Packet extends Entity{

    public function getAllPackets(){
        $sql = "SELECT 
                p.id,
                p.name,
                p.active,
                p.created_at,
                p.updated_at
            FROM packets p
            WHERE p.active = 1;";
        $data = Helpers::myQuery($sql);
        return $data;
    }

    public function getServicesByPacketId($id){
        $sql = "SELECT 
                s.id,
                s.name,
                s.description,
                ps.active
            FROM packets_services ps
            INNER JOIN services s 
                ON s.id = ps.id_service
            WHERE ps.id_packet = '$id' AND ps.active = 1;";
        $data = Helpers::myQuery($sql);
        return $data;
    }

    public function setServices(string $id_packet, array $services){
        try {
            // 1. Obtener servicios actuales del paquete
            $query = "SELECT id_service FROM packets_services WHERE id_packet = '$id_packet'";
            $result = Helpers::myQuery($query);
            $current_services = [];
            
            if ($result && count($result) > 0) {
                foreach ($result as $row) {
                    $current_services[] = $row['id_service'];
                }
            }
            
            // 2. Crear array de IDs de servicios recibidos
            $new_service_ids = [];
            foreach ($services as $service) {
                // Aceptar tanto objetos con id_service como strings directos
                if (is_array($service) && isset($service['id_service'])) {
                    $new_service_ids[] = $service['id_service'];
                } else if (is_string($service)) {
                    $new_service_ids[] = $service;
                }
            }
            
            // 3. Servicios a eliminar (están en BD pero no en el array recibido)
            $to_remove = array_diff($current_services, $new_service_ids);
            
            // 4. Servicios a agregar (están en el array pero no en BD)
            $to_add = array_diff($new_service_ids, $current_services);
            
            // 5. Eliminar servicios
            if (!empty($to_remove)) {
                foreach ($to_remove as $service_id) {
                    $delete_query = "DELETE FROM packets_services 
                                   WHERE id_packet = '$id_packet' 
                                   AND id_service = '$service_id'";
                    Helpers::myQuery($delete_query);
                }
            }
            
            // 6. Agregar nuevos servicios
            if (!empty($to_add)) {
                foreach ($to_add as $service_id) {
                    $key = new Key();
                    $id = $key->generate_uuid();
                    $insert_query = "INSERT INTO packets_services (id, id_packet, id_service) 
                                   VALUES ('$id', '$id_packet', '$service_id')";
                    Helpers::myQuery($insert_query);
                }
            }
            
            return [
                'success' => true,
                'added' => count($to_add),
                'removed' => count($to_remove),
                'total' => count($new_service_ids)
            ];
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}