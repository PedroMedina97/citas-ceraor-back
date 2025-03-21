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

    public function createOrder(String $name_table, array $body)
    {
        $key = new Key();
        $file = new File();
        $file->generatePDF($body);
        die();
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
        $three_d_risina = isset($body["3d_risina"]) ? $body["3d_risina"] : 0;
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
                    lateral_left_tomography_open_close, lateral_right_tomography_open_close, 
                    active, created_at, updated_at
                ) VALUES (
                    '$id', '$patient', '$birthdate', '$phone', '$doctor', '$address', 
                    '$professional_id', '$email', $acetate_print, $paper_print, $send_email, 
                    $rx_panoramic, $rx_arc_panoramic, $rx_lateral_skull, $ap_skull, $pa_skull, 
                    $paranasal_sinuses, $atm_open_close, $profilogram, $watters_skull, 
                    $palmar_digit, '$others_radiography', $occlusal_xray, $superior, $inferior, 
                    $complete_periapical, $individual_periapical, $conductometry, 
                    $clinical_photography, $rickets, $mcnamara, $downs, $jaraback, $steiner, 
                    '$others_analysis', $analysis_bolton, $analysis_moyers, '$others_models_analysis', 
                    $risina, $dentalprint, $three_d_risina, $surgical_guide, $studio_piece, 
                    $complete_tomography, $two_jaws_tomography, $maxilar_tomography, $jaw_tomography, 
                    $snp_tomography, $ear_tomography, $atm_tomography_open_close, 
                    $lateral_left_tomography_open_close, $lateral_right_tomography_open_close, 
                    1, NOW(), NOW()
        );";
        /* echo $query;
        die(); */
        $sql = Helpers::connect()->query($query);

        if (!$sql) {
            throw new \Exception(mysqli_error(Helpers::connect()));
        }
        return $sql; // Return the query result

    }


}
