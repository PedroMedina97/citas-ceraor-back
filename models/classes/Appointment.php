<?php

namespace Classes;

use Abstracts\Entity;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Utils\Env;
use Utils\Helpers;
use Utils\Key;
use Classes\Order;

class Appointment extends Entity
{


    public function setAppointment(String $client, String $personal, String $id_subsidiary, String $service, String $appointment, String $end_appointment, String $color, String $id_order = "")
    {
        $env = new Env();
        $conn = Helpers::connect();
        $order = new Order();

        // Sanitizar entradas
        $client = mysqli_real_escape_string($conn, $client);
        $personal = mysqli_real_escape_string($conn, $personal);
        $id_subsidiary = mysqli_real_escape_string($conn, $id_subsidiary);
        $service = mysqli_real_escape_string($conn, $service);
        $appointment = mysqli_real_escape_string($conn, $appointment);
        $end_appointment = mysqli_real_escape_string($conn, $end_appointment);
        $color = mysqli_real_escape_string($conn, $color);
        $id_order = mysqli_real_escape_string($conn, $id_order);

        // Validar traslape con otras citas del mismo doctor
        $checkQuery = "SELECT COUNT(*) AS total FROM appointments
                       WHERE personal = '$personal'
                       AND active = 1
                       AND (
                           ('$appointment' < end_appointment AND '$end_appointment' > appointment)
                       )";

        $resultCheck = $conn->query($checkQuery);
        $row = $resultCheck->fetch_assoc();

        if ($row['total'] > 0) {
            // Ya hay una cita en ese horario
            return false;
        }

        // Generar UUID y código de barras
        $key = new Key();
        $id = $key->generate_uuid();
        $data = $this->generateShortUuid($id);

        $directory = 'appointments-barcodes';
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($data, $generator::TYPE_CODE_128);
        $dataBarcode = $data . '.png';
        $filePath = $directory . '/' . $dataBarcode;
        file_put_contents($filePath, $barcode);

        // Insertar cita
        $query = "INSERT INTO appointments (id, id_order, client, personal, id_subsidiary, service, appointment, end_appointment, barcode, code, color, active, created_at, updated_at) 
                  VALUES (
                    '$id',
                    " . ($id_order ? "'$id_order'" : "NULL") . ",
                    '$client',
                    '$personal',
                    '$id_subsidiary',
                    '$service',
                    '$appointment',
                    '$end_appointment',
                    '$dataBarcode',
                    '$data',
                    '$color',
                    1,
                    NOW(),
                    NOW()
                  )";
        /* echo $query;
        die(); */
        $result = $conn->query($query);
        return $result;
    }

    public function getAvaliables($id_subsidiary, $date)
    {
        // Sanitiza (sigues con mysqli)
        $conn = Helpers::connect();
        $id_subsidiary = mysqli_real_escape_string($conn, $id_subsidiary);
        $date = mysqli_real_escape_string($conn, $date);

        $query = "
                WITH RECURSIVE
                params AS (
                SELECT
                    CAST(15 AS SIGNED) AS slot_minutes, -- tamaño de bloque (min)
                    CAST('$id_subsidiary' AS CHAR CHARACTER SET utf8mb4)
                    COLLATE utf8mb4_0900_ai_ci AS p_subsidiary_id,       -- fix colación
                    '$date' AS p_date,                                      -- 'YYYY-MM-DD'
                    '08:00:00' AS p_open,                                   -- jornada inicio
                    '20:00:00' AS p_close                                   -- jornada fin
                ),
                day_bounds AS (
                SELECT
                    TIMESTAMP(CONCAT(p_date,' ', p_open))  AS day_start,
                    TIMESTAMP(CONCAT(p_date,' ', p_close)) AS day_end
                FROM params
                ),
                slots AS (
                SELECT 
                    day_start AS slot_start,
                    TIMESTAMPADD(MINUTE, (SELECT slot_minutes FROM params), day_start) AS slot_end
                FROM day_bounds
                UNION ALL
                SELECT
                    TIMESTAMPADD(MINUTE, (SELECT slot_minutes FROM params), slot_start),
                    TIMESTAMPADD(MINUTE, (SELECT slot_minutes FROM params), slot_end)
                FROM slots, day_bounds
                WHERE slot_end < (SELECT day_end FROM day_bounds)
                ),
                appts AS (
                -- Citas que se solapan con el día en esa sucursal
                SELECT 
                    a.id,
                    GREATEST(a.appointment, (SELECT day_start FROM day_bounds)) AS start_time,
                    LEAST(
                    COALESCE(a.end_appointment, TIMESTAMPADD(MINUTE, 30, a.appointment)),
                    (SELECT day_end FROM day_bounds)
                    ) AS end_time
                FROM appointments a, params
                WHERE a.id_subsidiary = (SELECT p_subsidiary_id FROM params)
                    AND a.appointment <  TIMESTAMP(CONCAT((SELECT p_date FROM params),' 23:59:59'))
                    AND COALESCE(a.end_appointment, TIMESTAMPADD(MINUTE, 30, a.appointment)) >
                        TIMESTAMP(CONCAT((SELECT p_date FROM params),' 00:00:00'))
                )
                SELECT 
                s.slot_start,
                s.slot_end,
                CASE 
                    WHEN EXISTS (
                    SELECT 1 FROM appts x
                    WHERE x.start_time < s.slot_end
                        AND x.end_time   > s.slot_start
                    ) THEN 'occupied'
                    ELSE 'available'
                END AS status
                FROM slots s
                ORDER BY s.slot_start;
                    ";

        try {
            return Helpers::myQuery($query);
        } catch (\Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }



    public function getByBarcode(String $code)
    {
        $code = mysqli_real_escape_string(Helpers::connect(), $code);
        $query = "SELECT a.id AS appointment_id, a.code, a.appointment, a.color, a.barcode, a.client, a.personal, 
                o.id AS order_id, o.patient, o.birthdate, o.phone, o.doctor, o.address, s.name AS subsidiary_name, srv.name AS service_name, a.created_at, srv.name as service_name, srv.price
                FROM appointments a LEFT JOIN orders o ON a.id_order = o.id LEFT JOIN subsidiaries s ON a.id_subsidiary = s.id LEFT JOIN services srv ON a.service = srv.id 
                WHERE a.code = '$code';";
        /* $query = "SELECT * FROM appointments where code='$code' and active=1"; */
        /* echo $query;
        die(); */
        $appointments = Helpers::connect()->query($query);
        return $appointments->fetch_all(MYSQLI_ASSOC);
    }

    function generateShortUuid($uuid)
    {
        // Generar un hash único basado en el UUID
        $hash = md5($uuid . uniqid(mt_rand(), true));

        // Convertir los primeros 8 caracteres del hash en una cadena alfanumérica
        $shortUuid = substr(base_convert(substr($hash, 0, 16), 16, 36), 0, 8);

        return strtoupper($shortUuid); // Opcional: Convertir a mayúsculas para mejor legibilidad
    }

    function getDetailById(String $id)
    {
        $sql = "SELECT a.id AS appointment_id,
                a.client AS patient_name, s.name AS subsidiary_name,
                sv.name AS service_name, sv.price AS service_price,
                a.appointment AS appointment_datetime, a.personal AS staff_name
                FROM appointments a LEFT JOIN subsidiaries s ON a.id_subsidiary = s.id
                LEFT JOIN services sv ON a.service = sv.id WHERE a.id = '$id';";
        try {
            return Helpers::myQuery($sql);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function getBySubsidiary(String $id_subsidiary)
    {
        $conn = Helpers::connect();
        $id_subsidiary = mysqli_real_escape_string($conn, $id_subsidiary);

        $query = "SELECT 
                a.id,
                a.client,
                a.personal,
                a.service,
                srv.name AS service_name,
                a.id_subsidiary,
                s.name AS subsidiary_name,
                a.color,
                a.appointment,
                a.end_appointment
              FROM appointments a
              LEFT JOIN services srv ON a.service = srv.id
              LEFT JOIN subsidiaries s ON a.id_subsidiary = s.id
              WHERE a.id_subsidiary = '$id_subsidiary' AND a.active = 1";

        $result = $conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
