<?php

namespace Classes;
use Abstracts\Entity;
use Utils\Helpers;
use Utils\Key;

class Subsidiary extends Entity{

    /**
     * Setea los servicios de una sucursal (agrega y quita según el array recibido)
     * @param string $id_subsidiary ID de la sucursal
     * @param array $services Array de servicios con formato: [{"id_service": "uuid", "price": 100.50}, ...]
     * @return array Resultado de la operación
     */
    public function setServices(string $id_subsidiary, array $services){
        try {
            // 1. Obtener servicios actuales de la sucursal
            $query = "SELECT id_service, price FROM subsidiaries_services WHERE id_subsidiary = '$id_subsidiary'";
            $result = Helpers::myQuery($query);
            $current_services = [];
            
            if ($result && count($result) > 0) {
                foreach ($result as $row) {
                    $current_services[$row['id_service']] = $row['price'];
                }
            }
            
            // 2. Crear array de IDs de servicios recibidos
            $new_service_ids = [];
            $services_map = [];
            foreach ($services as $service) {
                $new_service_ids[] = $service['id_service'];
                $services_map[$service['id_service']] = $service['price'];
            }
            
            // 3. Servicios a eliminar (están en BD pero no en el array recibido)
            $to_remove = array_diff(array_keys($current_services), $new_service_ids);
            
            // 4. Servicios a agregar (están en el array pero no en BD)
            $to_add = array_diff($new_service_ids, array_keys($current_services));
            
            // 5. Servicios a actualizar (están en ambos pero con diferente precio)
            $to_update = [];
            foreach ($new_service_ids as $service_id) {
                if (isset($current_services[$service_id]) && $current_services[$service_id] != $services_map[$service_id]) {
                    $to_update[] = $service_id;
                }
            }
            
            // 6. Eliminar servicios
            if (!empty($to_remove)) {
                foreach ($to_remove as $service_id) {
                    $delete_query = "DELETE FROM subsidiaries_services 
                                   WHERE id_subsidiary = '$id_subsidiary' 
                                   AND id_service = '$service_id'";
                    Helpers::myQuery($delete_query);
                }
            }
            
            // 7. Agregar nuevos servicios
            if (!empty($to_add)) {
                foreach ($to_add as $service_id) {
                    $key = new Key();
                    $id = $key->generate_uuid();
                    $price = $services_map[$service_id];
                    $insert_query = "INSERT INTO subsidiaries_services (id, id_subsidiary, id_service, price) 
                                   VALUES ('$id', '$id_subsidiary', '$service_id', $price)";
                    Helpers::myQuery($insert_query);
                }
            }
            
            // 8. Actualizar precios
            if (!empty($to_update)) {
                foreach ($to_update as $service_id) {
                    $price = $services_map[$service_id];
                    $update_query = "UPDATE subsidiaries_services 
                                   SET price = $price 
                                   WHERE id_subsidiary = '$id_subsidiary' 
                                   AND id_service = '$service_id'";
                    Helpers::myQuery($update_query);
                }
            }
            
            return [
                'success' => true,
                'added' => count($to_add),
                'removed' => count($to_remove),
                'updated' => count($to_update),
                'total' => count($services)
            ];
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Obtiene los servicios de una sucursal con sus precios
     * @param string $id_subsidiary ID de la sucursal
     * @return array Servicios de la sucursal con precios
     */
    public function getServicesSubsidiary(string $id_subsidiary){
        $query = "SELECT s.id, s.name, s.description, ss.price, s.active 
                  FROM services s
                  INNER JOIN subsidiaries_services ss ON s.id = ss.id_service
                  WHERE ss.id_subsidiary = '$id_subsidiary' AND s.active = 1";
        return Helpers::myQuery($query);
    }

    /**
     * Obtiene todos los servicios activos del sistema
     * @return array Todos los servicios
     */
    public function getAllServices(){
        $query = "SELECT * FROM services WHERE active = 1 ORDER BY name";
        return Helpers::myQuery($query);
    }

    /**
     * Setea los paquetes de una sucursal (agrega y quita según el array recibido)
     * @param string $id_subsidiary ID de la sucursal
     * @param array $packets Array de paquetes con formato: [{"id_packet": "uuid", "price": 100.50}, ...]
     * @return array Resultado de la operación
     */
    public function setPackets(string $id_subsidiary, array $packets){
        try {
            // 1. Obtener paquetes actuales de la sucursal
            $query = "SELECT id_packet, price FROM subsidiaries_packets WHERE id_subsidiary = '$id_subsidiary'";
            $result = Helpers::myQuery($query);
            $current_packets = [];
            
            if ($result && count($result) > 0) {
                foreach ($result as $row) {
                    $current_packets[$row['id_packet']] = $row['price'];
                }
            }
            
            // 2. Crear array de IDs de paquetes recibidos
            $new_packet_ids = [];
            $packets_map = [];
            foreach ($packets as $packet) {
                $new_packet_ids[] = $packet['id_packet'];
                $packets_map[$packet['id_packet']] = $packet['price'];
            }
            
            // 3. Paquetes a eliminar (están en BD pero no en el array recibido)
            $to_remove = array_diff(array_keys($current_packets), $new_packet_ids);
            
            // 4. Paquetes a agregar (están en el array pero no en BD)
            $to_add = array_diff($new_packet_ids, array_keys($current_packets));
            
            // 5. Paquetes a actualizar (están en ambos pero con diferente precio)
            $to_update = [];
            foreach ($new_packet_ids as $packet_id) {
                if (isset($current_packets[$packet_id]) && $current_packets[$packet_id] != $packets_map[$packet_id]) {
                    $to_update[] = $packet_id;
                }
            }
            
            // 6. Eliminar paquetes
            if (!empty($to_remove)) {
                foreach ($to_remove as $packet_id) {
                    $delete_query = "DELETE FROM subsidiaries_packets 
                                   WHERE id_subsidiary = '$id_subsidiary' 
                                   AND id_packet = '$packet_id'";
                    Helpers::myQuery($delete_query);
                }
            }
            
            // 7. Agregar nuevos paquetes
            if (!empty($to_add)) {
                foreach ($to_add as $packet_id) {
                    $key = new Key();
                    $id = $key->generate_uuid();
                    $price = $packets_map[$packet_id];
                    $insert_query = "INSERT INTO subsidiaries_packets (id, id_subsidiary, id_packet, price) 
                                   VALUES ('$id', '$id_subsidiary', '$packet_id', $price)";
                    Helpers::myQuery($insert_query);
                }
            }
            
            // 8. Actualizar precios
            if (!empty($to_update)) {
                foreach ($to_update as $packet_id) {
                    $price = $packets_map[$packet_id];
                    $update_query = "UPDATE subsidiaries_packets 
                                   SET price = $price 
                                   WHERE id_subsidiary = '$id_subsidiary' 
                                   AND id_packet = '$packet_id'";
                    Helpers::myQuery($update_query);
                }
            }
            
            return [
                'success' => true,
                'added' => count($to_add),
                'removed' => count($to_remove),
                'updated' => count($to_update),
                'total' => count($packets)
            ];
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Obtiene los paquetes de una sucursal con sus precios
     * @param string $id_subsidiary ID de la sucursal
     * @return array Paquetes de la sucursal con precios
     */
    public function getPacketsSubsidiary(string $id_subsidiary){
        $query = "SELECT p.id, p.name, sp.price, p.active 
                  FROM packets p
                  INNER JOIN subsidiaries_packets sp ON p.id = sp.id_packet
                  WHERE sp.id_subsidiary = '$id_subsidiary' AND p.active = 1";
        return Helpers::myQuery($query);
    }

}