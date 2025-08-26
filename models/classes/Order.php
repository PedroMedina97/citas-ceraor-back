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
    

    public function createOrder(String $name_table, array $body)
    {
        $key = new Key();
        /*  $file = new File();
        $file->generatePDF($body);
        die(); */
        $id = $key->generate_uuid();
        $patient = $body["patient"];
        $birthdate = $body["birthdate"];
        $phone = $body["phone"];
        $doctor = $body["doctor"];
        $address = $body["address"];
        $professional_id = isset($body["professional_id"]) ? $body["professional_id"] : NULL;
        $email = isset($body["email"]) ? $body["email"] : NULL;
        $acetate_print = isset($body["acetate_print"]) ? $body["acetate_print"] : 0;
        $paper_print = isset($body["paper_print"]) ? $body["paper_print"] : 0;
        $send_email = isset($body["send_email"]) ? $body["send_email"] : 0;
        $rx_panoramic = isset($body["rx_panoramic"]) ? $body["rx_panoramic"] : 0;
        $rx_arc_panoramic = isset($body["rx_arc_panoramic"]) ? $body["rx_arc_panoramic"] : 0;
        $rx_lateral_skull = isset($body["rx_lateral_skull"]) ? $body["rx_lateral_skull"] : 0;
        $ap_skull = isset($body["ap_skull"]) ? $body["ap_skull"] : 0;
        $pa_skull = isset($body["pa_skull"]) ? $body["pa_skull"] : 0;
        $paranasal_sinuses = isset($body["paranasal_sinuses"]) ? $body["paranasal_sinuses"] : 0;
        $atm_open_close = isset($body["atm_open_close"]) ? $body["atm_open_close"] : 0;
        $profilogram = isset($body["profilogram"]) ? $body["profilogram"] : 0;
        $watters_skull = isset($body["watters_skull"]) ? $body["watters_skull"] : 0;
        $palmar_digit = isset($body["palmar_digit"]) ? $body["palmar_digit"] : 0;
        $others_radiography = isset($body["others_radiography"]) ? $body["others_radiography"] : NULL;
        $occlusal_xray = isset($body["occlusal_xray"]) ? $body["occlusal_xray"] : 0;
        $superior = isset($body["superior"]) ? $body["superior"] : 0;
        $inferior = isset($body["inferior"]) ? $body["inferior"] : 0;
        $complete_periapical = isset($body["complete_periapical"]) ? $body["complete_periapical"] : 0;
        $individual_periapical = isset($body["individual_periapical"]) ? $body["individual_periapical"] : 0;
        $conductometry = isset($body["conductometry"]) ? $body["conductometry"] : 0;
        $clinical_photography = isset($body["clinical_photography"]) ? $body["clinical_photography"] : 0;
        $rickets = isset($body["rickets"]) ? $body["rickets"] : 0;
        $mcnamara = isset($body["mcnamara"]) ? $body["mcnamara"] : 0;
        $downs = isset($body["downs"]) ? $body["downs"] : 0;
        $jaraback = isset($body["jaraback"]) ? $body["jaraback"] : 0;
        $steiner = isset($body["steiner"]) ? $body["steiner"] : 0;
        $others_analysis = isset($body["others_analysis"]) ? $body["others_analysis"] : NULL;
        $analysis_bolton = isset($body["analysis_bolton"]) ? $body["analysis_bolton"] : NULL;
        $analysis_moyers = isset($body["analysis_moyers"]) ? $body["analysis_moyers"] : 0;
        $others_models_analysis = isset($body["others_models_analysis"]) ? $body["others_models_analysis"] : NULL;
        $risina = isset($body["risina"]) ? $body["risina"] : 0;
        $dentalprint = isset($body["dentalprint"]) ? $body["dentalprint"] : 0;
        $three_d_risina = isset($body["risina_3d"]) ? $body["risina_3d"] : 0;
        $surgical_guide = isset($body["surgical_guide"]) ? $body["surgical_guide"] : 0;
        $studio_piece = isset($body["studio_piece"]) ? $body["studio_piece"] : 0;
        $complete_tomography = isset($body["complete_tomography"]) ? $body["complete_tomography"] : 0;
        $two_jaws_tomography = isset($body["two_jaws_tomography"]) ? $body["two_jaws_tomography"] : 0;
        $maxilar_tomography = isset($body["maxilar_tomography"]) ? $body["maxilar_tomography"] : 0;
        $jaw_tomography = isset($body["jaw_tomography"]) ? $body["jaw_tomography"] : 0;
        $snp_tomography = isset($body["snp_tomography"]) ? $body["snp_tomography"] : 0;
        $ear_tomography = isset($body["ear_tomography"]) ? $body["ear_tomography"] : 0;
        $atm_tomography_open_close = isset($body["atm_tomography_open_close"]) ? $body["atm_tomography_open_close"] : 0;
        $lateral_left_tomography_open_close = isset($body["lateral_left_tomography_open_close"]) ? $body["lateral_left_tomography_open_close"] : 0;
        $lateral_right_tomography_open_close = isset($body["lateral_right_tomography_open_close"]) ? $body["lateral_right_tomography_open_close"] : 0;

        $ondemand = isset($body["ondemand"]) ? $body["ondemand"] : 0;
        $dicom = isset($body["dicom"]) ? $body["dicom"] : 0;
        $tomography_piece = isset($body["tomography_piece"]) ? $body["tomography_piece"] : NULL;
        $implant = isset($body["implant"]) ? $body["implant"] : NULL;
        $impacted_tooth = isset($body["impacted_tooth"]) ? $body["impacted_tooth"] : NULL;
        $others_tomography = isset($body["others_tomography"]) ? $body["others_tomography"] : NULL;
        $stl = isset($body["stl"]) ? $body["stl"] : 0;
        $obj = isset($body["obj"]) ? $body["obj"] : 0;
        $ply = isset($body["ply"]) ? $body["ply"] : 0;
        $invisaligh = isset($body["invisaligh"]) ? $body["invisaligh"] : 0;
        $others_scanners = isset($body["others_scanners"]) ? $body["others_scanners"] : NULL;
        $maxilar_superior = isset($body["maxilar_superior"]) ? $body["maxilar_superior"] : 0;
        $maxilar_inferior = isset($body["maxilar_inferior"]) ? $body["maxilar_inferior"] : 0;
        $maxilar_both = isset($body["maxilar_both"]) ? $body["maxilar_both"] : 0;
        $maxilar_others = isset($body["maxilar_others"]) ? $body["maxilar_others"] : NULL;
        $dental_interpretation = isset($body["dental_interpretation"]) ? $body["dental_interpretation"] : 0;
        
        // Nuevas columnas status y method
        $status = isset($body["status"]) ? $body["status"] : 'solicitado';
        $method = isset($body["method"]) ? $body["method"] : 'por_definir';

        $query = "INSERT INTO $name_table (
                    id, patient, birthdate, phone, doctor, address, professional_id, email, 
                    acetate_print, paper_print, send_email, rx_panoramic, rx_arc_panoramic, 
                    rx_lateral_skull, ap_skull, pa_skull, paranasal_sinuses, atm_open_close, 
                    profilogram, watters_skull, palmar_digit, others_radiography, occlusal_xray, 
                    superior, inferior, complete_periapical, individual_periapical, conductometry, 
                    clinical_photography, rickets, mcnamara, downs, jaraback, steiner, 
                    others_analysis, analysis_bolton, analysis_moyers, others_models_analysis, 
                    risina, dentalprint, 3d_risina, surgical_guide, studio_piece, 
                    complete_tomography, two_jaws_tomography, maxilar_tomography, jaw_tomography, 
                    snp_tomography, ear_tomography, atm_tomography_open_close, 
                    lateral_left_tomography_open_close, lateral_right_tomography_open_close, ondemand,
                    dicom, tomography_piece, implant, impacted_tooth, others_tomography, stl, obj, ply, 
                    invisaligh, others_scanners, maxilar_superior, maxilar_inferior, maxilar_both, maxilar_others, dental_interpretation,
                    status, method, active, created_at, updated_at
                ) VALUES (
                    '$id', '$patient', '$birthdate', '$phone', '$doctor', '$address', 
                    '$professional_id', '$email', $acetate_print, $paper_print, $send_email, 
                    $rx_panoramic, $rx_arc_panoramic, $rx_lateral_skull, $ap_skull, $pa_skull, 
                    $paranasal_sinuses, $atm_open_close, $profilogram, $watters_skull, 
                    $palmar_digit, '$others_radiography', $occlusal_xray, $superior, $inferior, 
                    $complete_periapical, $individual_periapical, $conductometry, 
                    $clinical_photography, $rickets, $mcnamara, $downs, $jaraback, $steiner, 
                    '$others_analysis', $analysis_bolton, $analysis_moyers, '$others_models_analysis', 
                    $risina, $dentalprint, $three_d_risina, $surgical_guide, '$studio_piece', 
                    $complete_tomography, $two_jaws_tomography, $maxilar_tomography, $jaw_tomography, 
                    $snp_tomography, $ear_tomography, $atm_tomography_open_close, 
                    $lateral_left_tomography_open_close, $lateral_right_tomography_open_close, '$ondemand',
                    '$dicom', '$tomography_piece', '$implant', '$impacted_tooth', '$others_tomography', $stl, $obj, 
                    $ply, $invisaligh, '$others_scanners', $maxilar_superior, $maxilar_inferior, $maxilar_both, 
                    '$maxilar_others', $dental_interpretation, '$status', '$method', 1, NOW(), NOW()
        );";
       /*  echo $query;
        die(); */
        $sql = Helpers::connect()->query($query);
       /*  $this->generateDocument($id); */
        if (!$sql) {
            throw new \Exception(mysqli_error(Helpers::connect()));
        }
        return $sql; // Return the query result

    }

    public function getAllActiveOrders()
    {
        $sql = "SELECT o.*, 
                a.code AS appointment_code
                FROM orders o
                LEFT JOIN appointments a ON a.id_order = o.id
                WHERE o.active = 1
                ORDER BY o.created_at DESC;";
        return Helpers::myQuery($sql);    
    }

    public function generateDocument(String $code)
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
        o.patient,
        o.birthdate,
        o.phone,
        o.doctor,
        o.address,
        o.professional_id,
        o.email,
        o.acetate_print,
        o.paper_print,
        o.send_email,
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
        o.active AS order_active,
        o.created_at AS order_created_at,
        o.updated_at AS order_updated_at

            FROM appointments a
            JOIN orders o ON a.id_order = o.id
            WHERE a.code = '$code'
            ORDER BY a.created_at DESC
            LIMIT 1;
            ");
        $file = new File();
        return $file->generatePDF($data);
    }

    public function getDetailsById(String $id)
    {
        $query = "SELECT *  FROM orders WHERE id='$id' AND active =1 LIMIT 1;";
        return Helpers::myQuery($query);
    }

    public function generateTicket(String $id)
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
        
        $file = new File();
        return $file->generateTicketPDF($data);
    }
   

    public function generateDocumentById(String $id)
    {
        $query = "SELECT *  FROM orders WHERE id='$id' AND active =1 LIMIT 1;";
        $data = Helpers::myQuery($query);
        $file = new File();
        return $file->generatePDF($data);
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
