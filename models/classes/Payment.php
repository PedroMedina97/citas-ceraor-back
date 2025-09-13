<?php
namespace Classes;

use Abstracts\Entity;
use Utils\Helpers;

class Payment extends Entity
{

    public function getAllPayments(){
        $sql = "SELECT COALESCE(o.patient, a.client) AS nombre_paciente,
                COALESCE(s.name, a.service) AS nombre_servicio, sub.name AS sucursal,
                p.created_at AS fecha_hora_pago, p.amount AS cantidad FROM payments
                p LEFT JOIN appointments a ON p.id_appointment = a.id LEFT JOIN orders o ON a.id_order = o.id 
                LEFT JOIN services s ON a.service = s.id LEFT JOIN subsidiaries sub ON a.id_subsidiary = sub.id ORDER BY p.created_at DESC; ";
        try {
            return Helpers::myQuery($sql);
        } catch (\Exception $e) {
            error_log("Error: " . $e->getMessage());
            return ['error' => 'Error al ejecutar la consulta'];
        }
    }

    public function getPaymentById($id, $disposition = 'inline'){
        $sql = "SELECT
                p.id                                AS id_pago,
                p.method                            AS metodo_pago,
                p.amount                            AS cantidad,
                p.status                            AS estado,
                p.created_at                        AS fecha_hora_pago,
                p.updated_at                        AS fecha_actualizacion,
                COALESCE(o.patient, a.client)       AS nombre_paciente,
                COALESCE(s.name, a.service)         AS nombre_servicio,
                sub.name                            AS sucursal,
                a.appointment                       AS fecha_cita,
                a.end_appointment                   AS fin_cita,
                a.code                              AS codigo_cita,
                a.barcode                           AS codigo_barras
            FROM payments p
            LEFT JOIN appointments a   ON p.id_appointment = a.id
            LEFT JOIN orders o         ON a.id_order = o.id
            LEFT JOIN services s       ON a.service = s.id
            LEFT JOIN subsidiaries sub ON a.id_subsidiary = sub.id
            WHERE p.id = '$id';";
        try {
            $data = Helpers::myQuery($sql);
            /* var_dump($data);
            die(); */
            $file = new File();
            return $file->generatePaymentTicketPDF($data, $disposition);
        } catch (\Exception $e) {
            error_log("Error: " . $e->getMessage());
            return ['error' => 'Error al ejecutar la consulta'];
        }
    }
}
