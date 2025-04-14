<?php

namespace Classes;
use Abstracts\Entity;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Utils\Env;
use Utils\Helpers;
use Utils\Key;
use Classes\Order;

class Appointment extends Entity{

    public function setAppointment(String $id_order = "", String $client, String $personal, String $id_subsidiary, String $service, String $appointment, String $color){
        $env = new Env();
        $conn = Helpers::connect();
        $order = new Order();
        $client = mysqli_real_escape_string($conn, $client);
        $personal = mysqli_real_escape_string($conn, $personal);
        $id_subsidiary = mysqli_real_escape_string($conn, $id_subsidiary);
        $service = mysqli_real_escape_string($conn, $service);
        $appointment = mysqli_real_escape_string($conn, $appointment);
        $color = mysqli_real_escape_string($conn, $color); // Asegurar que el color se almacene correctamente
        $id_order = mysqli_real_escape_string($conn, $id_order);
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
        if($id_order == ""){
            $query = "INSERT INTO appointments (id, id_order, client, personal, id_subsidiary, service, appointment, barcode, code, color, active, created_at, updated_at) 
                  VALUES ('$id', null, '$client', '$personal', '$id_subsidiary', '$service', '$appointment', '$dataBarcode', '$data', '$color', 1, NOW(), NOW())";
        }else{
            $query = "INSERT INTO appointments (id, id_order, client, personal, id_subsidiary, service, appointment, barcode, code, color, active, created_at, updated_at) 
                  VALUES ('$id', '$id_order', '$client', '$personal', '$id_subsidiary', '$service', '$appointment', '$dataBarcode', '$data', '$color', 1, NOW(), NOW())";
            /* $order->generateDocument($id_order); */
        }
        
        $result = Helpers::connect()->query($query);
        return $result;
    }
    

    public function getByBarcode(String $code){
        $code = mysqli_real_escape_string(Helpers::connect(), $code);
        $query = "SELECT a.id AS appointment_id, a.code, a.appointment, a.color, a.barcode, a.client, a.personal, 
                o.id AS order_id, o.patient, o.birthdate, o.phone, o.doctor, o.address, s.name AS subsidiary_name, srv.name AS service_name, a.created_at
                FROM appointments a LEFT JOIN orders o ON a.id_order = o.id LEFT JOIN subsidiaries s ON a.id_subsidiary = s.id LEFT JOIN services srv ON a.service = srv.id 
                WHERE a.code = '$code';";
        /* $query = "SELECT * FROM appointments where code='$code' and active=1"; */
        /* echo $query;
        die(); */
        $appointments = Helpers::connect()->query($query);
        return $appointments->fetch_all(MYSQLI_ASSOC);
    }

    function generateShortUuid($uuid) {
        // Generar un hash único basado en el UUID
        $hash = md5($uuid . uniqid(mt_rand(), true));
    
        // Convertir los primeros 8 caracteres del hash en una cadena alfanumérica
        $shortUuid = substr(base_convert(substr($hash, 0, 16), 16, 36), 0, 8);
    
        return strtoupper($shortUuid); // Opcional: Convertir a mayúsculas para mejor legibilidad
    }
}