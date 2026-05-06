<?php

namespace Classes;

use Abstracts\Entity;
use Utils\Helpers;
use Utils\Key;
use Classes\File;

class Order extends Entity
{


    public function getOrdersByIdAppointment(String $name_table, String $id)
    {
        return Helpers::getByIdRelated($name_table, "appointment", $id);
    }

    public function getOrdersByDoctor(String $name)
    {
        $decodedName = strtolower(trim(urldecode($name)));
        $sql = "SELECT o.*,
                a.code AS appointment_code
            FROM orders o
            LEFT JOIN appointments a ON a.id_order = o.id
            WHERE LOWER(o.doctor) = '$decodedName'
            ORDER BY o.created_at desc;
            ;
        ";
    
        return Helpers::myQuery($sql);
    }

    function generateShortUuid($uuid) {
        // Generar un hash único basado en el UUID
        $hash = md5($uuid . uniqid(mt_rand(), true));
    
        // Convertir los primeros 8 caracteres del hash en una cadena alfanumérica
        $shortUuid = substr(base_convert(substr($hash, 0, 16), 16, 36), 0, 8);
    
        return strtoupper($shortUuid); // Opcional: Convertir a mayúsculas para mejor legibilidad
    }


   public function getFormOrder(string $id_subsidiary)
{
    // Escapar el valor para prevenir SQL injection
    $conn = Helpers::connect();
    $id_subsidiary_safe = $conn->real_escape_string($id_subsidiary);
    
    $sql = "
        SELECT JSON_OBJECT(
            
            'categories', (
                SELECT JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'id', c.id,
                        'name', c.name,
                        'inputs', c.inputs,
                        'services', IFNULL((
                            SELECT JSON_ARRAYAGG(
                                JSON_OBJECT(
                                    'id', s.id,
                                    'name', s.name,
                                    'description', s.description,
                                    'price', ss.price,
                                    'image', s.image
                                )
                            )
                            FROM services s
                            INNER JOIN subsidiaries_services ss 
                                ON ss.id_service = s.id
                            WHERE s.id_category = c.id
                              AND s.active = 1
                              AND ss.id_subsidiary = '$id_subsidiary_safe'
                        ), JSON_ARRAY())
                    )
                )
                FROM categories c
                WHERE c.active = 1
            ),

            'packets', (
                SELECT JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'id', p.id,
                        'name', p.name,
                        'price', sp.price,
                        'services', IFNULL((
                            SELECT JSON_ARRAYAGG(
                                JSON_OBJECT(
                                    'id', s2.id,
                                    'name', s2.name,
                                    'description', s2.description
                                )
                            )
                            FROM packets_services ps
                            INNER JOIN services s2 
                                ON s2.id = ps.id_service
                            WHERE ps.id_packet = p.id
                              AND ps.active = 1
                        ), JSON_ARRAY())
                    )
                )
                FROM packets p
                INNER JOIN subsidiaries_packets sp 
                    ON sp.id_packet = p.id
                WHERE p.active = 1
                  AND sp.id_subsidiary = '$id_subsidiary_safe'
            )

        ) AS data;
    ";

    $result = Helpers::myQuery($sql);

    return isset($result[0]['data'])
        ? json_decode($result[0]['data'], true)
        : [];
}

    public function getAllActiveOrders()
    {
        $sql = "
                SELECT 
            o.id,
            o.folio_order,
            o.patient,
            o.doctor,
            o.status,
            o.method,
            o.created_at,

            a.id AS appointment_id,
            a.appointment,
            
            COALESCE(SUM(p.amount), 0) AS total_paid

        FROM orders o

        LEFT JOIN appointments a 
            ON a.id_order = o.id AND a.active = 1

        LEFT JOIN payments p 
            ON p.id_appointment = a.id AND p.active = 1

        WHERE o.active = 1

        GROUP BY 
            o.id, o.folio_order, o.patient, o.doctor, 
            o.status, o.method, o.created_at,
            a.id, a.appointment

        ORDER BY o.created_at DESC;
        ";
        return Helpers::myQuery($sql);    
    }

    public function generateDocument(String $code, string $disposition = 'inline')
    {
        $data = Helpers::myQuery("SELECT 
        a.id AS appointment_id,
        a.id_order,
        a.client,
        a.personal,
        a.id_subsidiary,
        a.service,
        a.appointment,
        a.barcode,
        a.code,
        a.color,
        a.active AS appointment_active,
        a.created_at AS appointment_created_at,
        a.updated_at AS appointment_updated_at,

        o.id AS order_id,
        o.folio_order,
        o.patient,
        o.birthdate,
        o.phone,
        o.doctor,
        o.address,
        o.professional_id,
        o.email,
        o.rx_panoramic,
        o.rx_arc_panoramic,
        o.rx_lateral_skull,
        o.ap_skull,
        o.pa_skull,
        o.paranasal_sinuses,
        o.atm_open_close,
        o.profilogram,
        o.watters_skull,
        o.palmar_digit,
        o.others_radiography,
        o.occlusal_xray,
        o.superior,
        o.inferior,
        o.complete_periapical,
        o.individual_periapical,
        o.conductometry,
        o.clinical_photography,
        o.rickets,
        o.mcnamara,
        o.downs,
        o.jaraback,
        o.steiner,
        o.others_analysis,
        o.analysis_bolton,
        o.analysis_moyers,
        o.others_models_analysis,
        o.risina,
        o.dentalprint,
        o.`3d_risina`,
        o.surgical_guide,
        o.studio_piece,
        o.complete_tomography,
        o.two_jaws_tomography,
        o.maxilar_tomography,
        o.jaw_tomography,
        o.snp_tomography,
        o.ear_tomography,
        o.atm_tomography_open_close,
        o.lateral_left_tomography_open_close,
        o.lateral_right_tomography_open_close,
        o.ondemand,
        o.dicom,
        o.tomography_piece,
        o.implant,
        o.impacted_tooth,
        o.others_tomography,
        o.stl,
        o.obj,
        o.ply,
        o.invisaligh,
        o.others_scanners,
        o.maxilar_superior,
        o.maxilar_inferior,
        o.maxilar_both,
        o.maxilar_others,
        o.dental_interpretation,
        o.status,
        o.method,
        o.content,
        o.active AS order_active,
        o.created_at AS order_created_at,
        o.updated_at AS order_updated_at

            FROM appointments a
            JOIN orders o ON a.id_order = o.id
            WHERE a.code = '$code'
            ORDER BY a.created_at DESC
            LIMIT 1;
            ");
            
        // Validar que se encontraron datos
        if (empty($data)) {
            throw new \Exception("No se encontraron datos para generar el documento");
        }
        
        $file = new File();
        return $file->generatePDF($data, $disposition);
    }


    public function getDetailsById(String $id)
    {
        $query = "
                        SELECT 
                -- Orden
                o.id AS order_id,
                o.folio_order,
                o.patient,
                o.birthdate,
                o.phone,
                o.doctor,
                o.email,
                o.status,
                o.method,
                o.content,
                o.created_at AS order_created_at,

                -- Cita
                a.id AS appointment_id,
                a.appointment,
                a.end_appointment,
                a.client,
                a.personal,
                a.service AS service_id,
                a.id_subsidiary,

                -- Servicio
                s.name AS service_name,
                c.name AS category_name,

                -- Sucursal
                sub.name AS subsidiary_name,
                sub.address AS subsidiary_address,

                -- Pagos
                p.id AS payment_id,
                p.method AS payment_method,
                p.amount,
                p.status AS payment_status,

                -- Notas
                n.description AS note

            FROM orders o

            LEFT JOIN appointments a 
                ON a.id_order = o.id AND a.active = 1

            LEFT JOIN services s 
                ON s.id = a.service AND s.active = 1

            LEFT JOIN categories c 
                ON c.id = s.id_category AND c.active = 1

            LEFT JOIN subsidiaries sub 
                ON sub.id = a.id_subsidiary AND sub.active = 1

            LEFT JOIN payments p 
                ON p.id_appointment = a.id AND p.active = 1

            LEFT JOIN notes n 
                ON n.id_order = o.id AND n.active = 1

            WHERE o.id = '$id'
            AND o.active = 1;
        ";
        return Helpers::myQuery($query);
    }

    public function generateTicket(String $id, string $disposition = 'inline')
    {
        $query = "SELECT 
                    o.id AS id_orden, 
                    o.patient AS nombre_paciente, 
                    o.phone AS telefono_contacto, 
                    o.updated_at AS fecha_actualizacion, 
                    o.doctor AS nombre_doctor, 
                    o.method AS metodo, 
                    o.code_ticket,
                    o.status,
                    s.name AS servicio 
                  FROM orders o 
                  LEFT JOIN appointments a ON o.id = a.id_order 
                  LEFT JOIN services s ON a.service = s.id 
                  WHERE o.id = '$id' AND o.active = 1;";
        /* echo $query; */
        $data = Helpers::myQuery($query);
        
        if (empty($data)) {
            throw new \Exception("Orden no encontrada");
        }
        
        // Verificar si la orden está entregada pero no tiene code_ticket
        $orderData = $data[0];
        if ($orderData['status'] === 'entregado' && empty($orderData['code_ticket'])) {
            // Intentar generar el código de ticket si la orden está entregada
            try {
                $this->generateAndAssignTicketCode($id);
                // Volver a consultar los datos actualizados
                $data = Helpers::myQuery($query);
            } catch (\Exception $e) {
                error_log("Error generando código de ticket para orden $id: " . $e->getMessage());
            }
        }
        
        // Validar que se encontraron datos
        if (empty($data)) {
            throw new \Exception("No se encontró la orden con ID: $id para generar el ticket");
        }
        
        $file = new File();
        return $file->generateTicketPDF($data, $disposition);
    }
   

    public function generateDocumentById(String $id, string $disposition = 'inline')
    {
        $data = Helpers::myQuery("SELECT 
        COALESCE(a.id, 'N/A') AS appointment_id,
        o.id AS id_order,
        COALESCE(a.client, 'N/A') AS client,
        COALESCE(a.personal, 'N/A') AS personal,
        COALESCE(a.id_subsidiary, 'N/A') AS id_subsidiary,
        COALESCE(a.service, 'N/A') AS service,
        COALESCE(a.appointment, NOW()) AS appointment,
        COALESCE(a.barcode, 'N/A') AS barcode,
        COALESCE(a.code, 'N/A') AS code,
        COALESCE(a.color, '#000000') AS color,
        COALESCE(a.active, 1) AS appointment_active,
        COALESCE(a.created_at, o.created_at) AS appointment_created_at,
        COALESCE(a.updated_at, o.updated_at) AS appointment_updated_at,

        o.id AS order_id,
        o.folio_order,
        o.patient,
        o.birthdate,
        o.phone,
        o.doctor,
        o.address,
        o.professional_id,
        o.email,
        o.rx_panoramic,
        o.rx_arc_panoramic,
        o.rx_lateral_skull,
        o.ap_skull,
        o.pa_skull,
        o.paranasal_sinuses,
        o.atm_open_close,
        o.profilogram,
        o.watters_skull,
        o.palmar_digit,
        o.others_radiography,
        o.occlusal_xray,
        o.superior,
        o.inferior,
        o.complete_periapical,
        o.individual_periapical,
        o.conductometry,
        o.clinical_photography,
        o.rickets,
        o.mcnamara,
        o.downs,
        o.jaraback,
        o.steiner,
        o.others_analysis,
        o.analysis_bolton,
        o.analysis_moyers,
        o.others_models_analysis,
        o.risina,
        o.dentalprint,
        o.`3d_risina`,
        o.surgical_guide,
        o.studio_piece,
        o.complete_tomography,
        o.two_jaws_tomography,
        o.maxilar_tomography,
        o.jaw_tomography,
        o.snp_tomography,
        o.ear_tomography,
        o.atm_tomography_open_close,
        o.lateral_left_tomography_open_close,
        o.lateral_right_tomography_open_close,
        o.ondemand,
        o.dicom,
        o.tomography_piece,
        o.implant,
        o.impacted_tooth,
        o.others_tomography,
        o.stl,
        o.obj,
        o.ply,
        o.invisaligh,
        o.others_scanners,
        o.maxilar_superior,
        o.maxilar_inferior,
        o.maxilar_both,
        o.maxilar_others,
        o.dental_interpretation,
        o.status,
        o.method,
        o.content,
        o.active AS order_active,
        o.created_at AS order_created_at,
        o.updated_at AS order_updated_at

            FROM orders o
            LEFT JOIN appointments a ON a.id_order = o.id
            WHERE o.id = '$id' AND o.active = 1
            ORDER BY COALESCE(a.created_at, o.created_at) DESC
            LIMIT 1;
            ");
            
        // Validar que se encontraron datos
        if (empty($data)) {
            throw new \Exception("No se encontró la orden con ID: $id");
        }
        
        $file = new File();
        return $file->generatePDF($data, $disposition);
    }





    /**
     * Actualizar el status de una orden
     * @param String $id ID de la orden
     * @param String $status Nuevo status (solicitado, en_proceso, entregado)
     * @return bool Resultado de la operación
     */
    public function updateOrderStatus(String $id, String $status)
    {
        // Validar que el status sea uno de los valores permitidos
        $allowedStatuses = ['solicitado', 'en_proceso', 'entregado'];
        if (!in_array($status, $allowedStatuses)) {
            throw new \Exception("Status no válido. Valores permitidos: " . implode(', ', $allowedStatuses));
        }

        $query = "UPDATE orders SET status = '$status', updated_at = NOW() WHERE id = '$id' AND active = 1";
        /* echo $query;
        die(); */
        $sql = Helpers::connect()->query($query);
        
        if (!$sql) {
            throw new \Exception(mysqli_error(Helpers::connect()));
        }
        
        // Si el status es 'entregado', generar código de ticket automáticamente
        if ($status === 'entregado') {
            try {
                $this->generateAndAssignTicketCode($id);
            } catch (\Exception $e) {
                // Log del error pero no fallar la actualización del status
                error_log("Error generando código de ticket para orden $id: " . $e->getMessage());
            }
        }
        
        return $sql;
    }

    /**
     * Actualizar el método de una orden
     * @param String $id ID de la orden
     * @param String $method Nuevo método (fisico, digital, ambos, por_definir)
     * @return bool Resultado de la operación
     */
    public function updateOrderMethod(String $id, String $method)
    {
        // Validar que el method sea uno de los valores permitidos
        $allowedMethods = ['fisico', 'digital', 'ambos', 'por_definir'];
        if (!in_array($method, $allowedMethods)) {
            throw new \Exception("Método no válido. Valores permitidos: " . implode(', ', $allowedMethods));
        }

        $query = "UPDATE orders SET method = '$method', updated_at = NOW() WHERE id = '$id' AND active = 1";
        $sql = Helpers::connect()->query($query);
        
        if (!$sql) {
            throw new \Exception(mysqli_error(Helpers::connect()));
        }
        
        return $sql;
    }

    /**
     * Obtener órdenes filtradas por status
     * @param String $status Status a filtrar (solicitado, en_proceso, entregado)
     * @return array Órdenes encontradas
     */
    public function getOrdersByStatus(String $status)
    {
        $allowedStatuses = ['solicitado', 'en_proceso', 'entregado'];
        if (!in_array($status, $allowedStatuses)) {
            throw new \Exception("Status no válido. Valores permitidos: " . implode(', ', $allowedStatuses));
        }

        $sql = "SELECT o.*, 
                a.code AS appointment_code
                FROM orders o
                LEFT JOIN appointments a ON a.id_order = o.id
                WHERE o.active = 1 AND o.status = '$status'
                ORDER BY o.created_at DESC;";
        
        return Helpers::myQuery($sql);
    }

    /**
     * Obtener órdenes filtradas por método
     * @param String $method Método a filtrar (fisico, digital, ambos, por_definir)
     * @return array Órdenes encontradas
     */
    public function getOrdersByMethod(String $method)
    {
        $allowedMethods = ['fisico', 'digital', 'ambos', 'por_definir'];
        if (!in_array($method, $allowedMethods)) {
            throw new \Exception("Método no válido. Valores permitidos: " . implode(', ', $allowedMethods));
        }

        $sql = "SELECT o.*, 
                a.code AS appointment_code
                FROM orders o
                LEFT JOIN appointments a ON a.id_order = o.id
                WHERE o.active = 1 AND o.method = '$method'
                ORDER BY o.created_at DESC;";
        
        return Helpers::myQuery($sql);
    }

    /**
     * Generar código único y corto para ticket de orden
     * Similar al sistema de códigos de appointments pero con prefijo TK
     * @return string Código único de 6-8 caracteres
     */
    private function generateTicketCode()
    {
        $attempts = 0;
        $maxAttempts = 10;
        
        do {
            // Generar un hash único
            $hash = md5(uniqid(mt_rand(), true) . microtime());
            
            // Convertir a base36 y tomar los primeros 6 caracteres
            $code = 'TK' . strtoupper(substr(base_convert(substr($hash, 0, 12), 16, 36), 0, 6));
            
            // Verificar que el código no existe en la base de datos
            $query = "SELECT COUNT(*) as count FROM orders WHERE code_ticket = '$code'";
            $result = Helpers::myQuery($query);
            $exists = $result[0]['count'] > 0;
            
            $attempts++;
            
        } while ($exists && $attempts < $maxAttempts);
        
        if ($attempts >= $maxAttempts) {
            throw new \Exception("No se pudo generar un código de ticket único después de $maxAttempts intentos");
        }
        
        return $code;
    }

    /**
     * Generar y asignar código de ticket a una orden
     * Solo se ejecuta cuando el status cambia a 'entregado'
     * @param String $id ID de la orden
     * @return string|null Código generado o null si ya existe
     */
    public function generateAndAssignTicketCode(String $id)
    {
        // Verificar si la orden ya tiene código de ticket
        $query = "SELECT code_ticket FROM orders WHERE id = '$id' AND active = 1";
        $result = Helpers::myQuery($query);
        
        if (empty($result)) {
            throw new \Exception("Orden no encontrada");
        }
        
        // Si ya tiene código, no generar uno nuevo
        if (!empty($result[0]['code_ticket'])) {
            return $result[0]['code_ticket'];
        }
        
        // Generar nuevo código
        $ticketCode = $this->generateTicketCode();
        
        // Actualizar la orden con el nuevo código
        $updateQuery = "UPDATE orders SET code_ticket = '$ticketCode', updated_at = NOW() WHERE id = '$id' AND active = 1";
        $updateResult = Helpers::connect()->query($updateQuery);
        
        if (!$updateResult) {
            throw new \Exception("Error al asignar código de ticket: " . mysqli_error(Helpers::connect()));
        }
        
        return $ticketCode;
    }

    /**
     * Obtener órdenes que tienen código de ticket (entregadas)
     * @return array Órdenes con código de ticket
     */
    public function getOrdersWithTicketCode()
    {
        $sql = "SELECT o.*, 
                a.code AS appointment_code
                FROM orders o
                LEFT JOIN appointments a ON a.id_order = o.id
                WHERE o.active = 1 AND o.code_ticket IS NOT NULL
                ORDER BY o.updated_at DESC;";
        
        return Helpers::myQuery($sql);
    }

    /**
     * Buscar orden por código de ticket
     * @param String $ticketCode Código del ticket
     * @return array|null Información de la orden
     */
    public function getOrderByTicketCode(String $ticketCode)
    {
        $sql = "SELECT o.*, 
                a.code AS appointment_code
                FROM orders o
                LEFT JOIN appointments a ON a.id_order = o.id
                WHERE o.active = 1 AND o.code_ticket = '$ticketCode'
                LIMIT 1;";
        
        $result = Helpers::myQuery($sql);
        return !empty($result) ? $result[0] : null;
    }
}
