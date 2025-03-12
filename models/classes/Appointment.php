<?php

namespace Classes;
use Abstracts\Entity;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Utils\Env;
use Utils\Helpers;
use Utils\Key;

class Appointment extends Entity{

    public function setAppointment(String $client, String $personal, String $id_subsidiary, String $service, String $appointment, String $color){
        $env = new Env();
        $conn = Helpers::connect();
        
        $client = mysqli_real_escape_string($conn, $client);
        $personal = mysqli_real_escape_string($conn, $personal);
        $id_subsidiary = mysqli_real_escape_string($conn, $id_subsidiary);
        $service = mysqli_real_escape_string($conn, $service);
        $appointment = mysqli_real_escape_string($conn, $appointment);
        $color = mysqli_real_escape_string($conn, $color); // Asegurar que el color se almacene correctamente
    
        $key = new Key();
        $id = $key->generate_uuid();
        $dataBarcode = $this->generateShortUuid($id);
    
        $directory = 'appointments-barcodes';
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
    
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($dataBarcode, $generator::TYPE_CODE_128);
        $filePath = $directory . '/' . $dataBarcode . '.png';
        file_put_contents($filePath, $barcode);
        $url = $env->server.'/'.$filePath;
    
        $query = "INSERT INTO appointments (id, client, personal, id_subsidiary, service, appointment, barcode, code, color, active, created_at, updated_at) 
                  VALUES ('$id', '$client', '$personal', '$id_subsidiary', '$service', '$appointment', '$url', '$dataBarcode', '$color', 1, NOW(), NOW())";
    
        $result = Helpers::connect()->query($query);
        return $result;
    }
    

    public function getByBarcode(String $code){
        $code = mysqli_real_escape_string(Helpers::connect(), $code);
        $query = "SELECT * FROM appointments where code='$code' and active=1";
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