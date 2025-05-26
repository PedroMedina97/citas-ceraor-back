<?php

namespace Classes;

use Dompdf\Dompdf;
use Dompdf\Options;



class File
{
    /* public function getFile($filename) {
    
        $basePath = realpath(__DIR__ . '/../../'); 
        $filePath = $basePath . "\\docs\\" . basename($filename);

        if (!file_exists($filePath)) {
            http_response_code(404);
            echo json_encode(["error" => "El archivo no existe en: " . $filePath]);
            exit;
        }


        header("Content-Type: " . mime_content_type($filePath));
        header("Content-Disposition: inline; filename=\"" . basename($filePath) . "\"");
        header("Content-Length: " . filesize($filePath));

        readfile($filePath);
        exit;
    } */

    public static function generatePDF(array $dataPDF)
    {
        // Configurar Dompdf

        $info = $dataPDF[0];
        /* var_dump($info);
        die(); */
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        // Cargar Bootstrap localmente
        $bootstrapCSS = file_get_contents('vendor/twbs/bootstrap/dist/css/bootstrap.min.css');


        // Función para subrayar valores si son 1 y mostrar 0 correctamente
        function formatValue($value)
        {
            $pathTrue = 'assets/images/true.png';
            $pathFalse = 'assets/images/false.png';
            $typeTrue = pathinfo($pathTrue, PATHINFO_EXTENSION);
            $typeFalse = pathinfo($pathFalse, PATHINFO_EXTENSION);
            $dataTrue = file_get_contents($pathTrue);
            $dataFalse = file_get_contents($pathFalse);
            $base64True = 'data:image/' . $typeTrue . ';base64,' . base64_encode($dataTrue);
            $base64False = 'data:image/' . $typeFalse . ';base64,' . base64_encode($dataFalse);
            return ($value === "1") ? "<img src='" . $base64True . "' width='10' height='10'>" : ($value === "0" ? "<img src='" . $base64False . "' width='10' height='10'>" : $value);
        }

        $path = 'assets/images/logo_ceraor.png';
        $pathCruze = 'assets/images/cruceta.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $typeCruze = pathinfo($pathCruze, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $dataCruze = file_get_contents($pathCruze);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        $base64Cruze = 'data:image/' . $typeCruze . ';base64,' . base64_encode($dataCruze);
        /* var_dump($info);
        die(); */
        if (array_key_exists('barcode', $info)) {
            $pathBarcode = "appointments-barcodes/" . $info['barcode'];
            $typeBarcode = pathinfo($pathBarcode, PATHINFO_EXTENSION);
            $dataBarcode = file_get_contents($pathBarcode);
            $base64Barcode = 'data:image/' . $typeBarcode . ';base64,' . base64_encode($dataBarcode);
        } else {
            $pathBarcode = $info['barcode'] = "assets/images/sin-folio.png";
            $typeBarcode = pathinfo($pathBarcode, PATHINFO_EXTENSION);
            $dataBarcode = file_get_contents($pathBarcode);
            $base64Barcode = 'data:image/' . $typeBarcode . ';base64,' . base64_encode($dataBarcode);
        }

        if (!array_key_exists('code', $info)) {
            $info['code'] = "sin-folio";
        }
        if (!array_key_exists('order_created_at', $info)) {
            $info['order_created_at'] =  date("Y-m-d");
            echo $info['order_created_at'];
            /*  die(); */
        }

        /* echo getcwd();
        die(); */
        // Estructura HTML con secciones bien organizadas
        $html = "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Reporte PDF</title>
           <style rel='stylesheet'>" . $bootstrapCSS . "</style>

        </head>
        <body>
        <table style='width: 100% !important; table-layout: fixed !important;'>
                <thead>
                    <th style='font-size: 11px'>Villahermosa</th>
                    <th style='font-size: 11px'>Cárdenas</th>
                    <th style='font-size: 11px'>Comalcalco</th>
                    <th style='font-size: 11px'>Tuxtla Gutiérrez</th>
                </thead>
                <tr>
                    <td style='background-color: #f2f2f2 !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table>
                            <tr>
                                <td style='font-size: 10px'><b>Dirección:</b> Blvd. Adolfo Ruiz Cortines  No.804 Magisterial, Vhsa., Tab. C.P. 86040</td>
                            </tr>
                            <tr>
                                <td style='font-size: 10px'><b>Teléfono(s):</b> 993-324-6453, 993-314-4353, 993-151-9846, 993-151-9847</td>
                            </tr>
                            <tr>
                                <td style='font-size: 10px'><b>WhatsApp:</b> 993-264-3105</td>
                            </tr>
                        </table>
                    </td>
                    <td style='background-color: #f2f2f2 !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table>
                            <tr>
                                <td style='font-size: 10px'><b>Dirección:</b> Av. Lázaro Cárdenas No. 1000 Local 20 Plaza Aqua, Col. Centro, Cárdenas, Tabasco. C.P.86500</td>
                            </tr>
                            <tr>
                                <td style='font-size: 10px'><b>Teléfono(s):</b> 937-668-5556, 937-668-5624</td>
                            </tr>
                            <tr>
                                <td style='font-size: 10px'><b>WhatsApp:</b> 937-108-2076</td>
                            </tr>
                        </table>
                    </td>
                    <td style='background-color: #f2f2f2 !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table>
                            <tr>
                                <td style='font-size: 10px'><b>Dirección: </b>Calle Bicentenario Manzana 1 Lote 8, Fracc. Santo Domingo, (frente al ADO) Comalcalco, Tab. C.P. 86340</td>
                            </tr>
                            <tr>
                                <td style='font-size: 10px'><b>Teléfono(s): </b> 933-109-4400</td>
                            </tr>
                            <tr>
                                <td style='font-size: 10px'><b>WhatsApp: </b>933-129-6910</td>
                            </tr>
                        </table>
                    </td>
                    <td style='background-color: #f2f2f2 !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table>
                            <tr>
                                <td style='font-size: 10px'><b>Dirección: </b>Calle San Francisco El Sabinal 228 Planta Baja, Col. San Francisco Sabinal, Tuxtla Gutiérrez, Chiapas. C.P. 29020</td>
                            </tr>
                            <tr>
                                <td style='font-size: 10px'><b>Teléfono(s): </b>961-125-9687</td>
                            </tr>
                            <tr>
                                <td style='font-size: 10px'><b>WhatsApp: </b> 961-367-9746</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        <table style='width: 100%;'>
            <tr>
                <td style='width: 50%; text-align: left;'>
                    <img src='" . $base64 . "' width='100' height='100'>
                </td>
                <td style='width: 50%; text-align: left;'>
                    <center>
                        <img src='" . $base64Barcode . "' width='200' height='50'>
                    </center>
                </td>
                <td style='width: 50%; text-align: right; vertical-align: middle;'>
                    <label style='display: block; text-align: right;'>Fecha: " . $info['order_created_at'] . "</label>
                </td>
            </tr>
        </table>     
        <center>
            <h3 style= padding: none !important; margin: none !important>ORDEN DE ESTUDIOS</h3>
        </center>
            <table style='width: 100% !important; table-layout: fixed !important; border-spacing: 10px !important;'>
                <thead>
                    <th style='font-size: 12px'>Folio: " . $info['code'] . "</th>
                </thead>
                <tr>
                    <td style='width: 100% !important; background-color: #f2f2f2 !important; padding: 10px !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table style='width: 100%; border-collapse: collapse; text-align: center;'>
                            <tr>
                                <th style='font-size: 12px; border: 1px solid #ddd; padding: 3px;'>Paciente</th>
                                <th style='font-size: 12px; border: 1px solid #ddd; padding: 3px;'>F. Nacimiento</th>
                                <th style='font-size: 12px; border: 1px solid #ddd; padding: 3px;'>Dirección</th>
                                <th style='font-size: 12px; border: 1px solid #ddd; padding: 3px;'>E-mail</th>
                                <th style='font-size: 12px; border: 1px solid #ddd; padding: 3px;'>Teléfono</th>
                            </tr>
                            <tr>
                                <td style='font-size: 11px; border: 1px solid #ddd; padding: 3px;'>" . formatValue($info['patient']) . "</td>
                                <td style='font-size: 11px; border: 1px solid #ddd; padding: 3px;'>" . formatValue($info['birthdate']) . "</td>
                                <td style='font-size: 11px; border: 1px solid #ddd; padding: 3px;'>" . formatValue($info['address']) . "</td>
                                <td style='font-size: 11px; border: 1px solid #ddd; padding: 3px;'>" . formatValue($info['email']) . "</td>
                                <td style='font-size: 11px; border: 1px solid #ddd; padding: 3px;'>" . formatValue($info['phone']) . "</td>
                            </tr>
                        </table>
                    </td>

                </tr>
                <tr>
                <td>
                    <table style='width: 100%; border-collapse: collapse; text-align: center;  background-color: #e0f7fa !important;'>
                        <tr>
                            <th style='font-size: 12px; border: 1px solid #ddd; padding: 3px;'>Doctor</th>
                            <th style='font-size: 12px; border: 1px solid #ddd; padding: 3px;'>Cédula</th>
                        </tr>
                        <tr>
                            <td style='font-size: 12px; border: 1px solid #ddd; padding: 3px;'>" . formatValue($info['doctor']) . "</td>
                            <td style='font-size: 12px; border: 1px solid #ddd; padding: 3px;'>" . formatValue($info['professional_id']) . "</td>
                        </tr>
                    </table>
                </td>

                </tr>
            </table>
            <table style='width: 100% !important; table-layout: fixed !important; border-spacing: 10px !important;'>
                <thead>
                    <th style='font-size: 12px'>
                        Radiografías
                    </th>
                    <th>
                    </th>
                    <th style='font-size: 12px'>
                        Análisis Cefalométricos
                    </th>  
                </thead>
                <tr>
                    <td style='width: 33.3% !important; background-color: #f2f2f2 !important; padding: 10px !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table>
                            <tr style='font-size: 11px !important;'><td>Rx Panorámica </td><td>" . formatValue($info['rx_panoramic']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Rx Arcada Panorámica </td><td>" . formatValue($info['rx_arc_panoramic']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Rx Lateral de Cráneo </td><td>" . formatValue($info['rx_lateral_skull']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Rx AP Cráneo </td><td>" . formatValue($info['ap_skull']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Rx PA Cráneo </td><td>" . formatValue($info['pa_skull']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Senos Paranasales </td><td>" . formatValue($info['paranasal_sinuses']) . "</td></tr>
                        </table>
                    </td>
                     <td style='width: 33.3% !important; background-color: #f2f2f2 !important; padding: 10px !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table>
                            <tr style='font-size: 11px !important;'><td>ATM Apertura y Cierre </td><td>" . formatValue($info['atm_open_close']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Perfilograma </td><td>" . formatValue($info['profilogram']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Cráneo de Watters </td><td>" . formatValue($info['watters_skull']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Palmar y Digitales </td><td>" . formatValue($info['palmar_digit']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Otros </td><td>" . formatValue($info['others_radiography']) . "</td></tr>
                        </table>
                    </td>
                    <td style='width: 33.3% !important; background-color: #e0f7fa !important; padding: 10px !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table>
                            <tr style='font-size: 11px !important;'><td>Rickets</td><td>" . formatValue($info['rickets']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>McNamara</td><td>" . formatValue($info['mcnamara']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Downs</td><td>" . formatValue($info['downs']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Jaraback</td><td>" . formatValue($info['jaraback']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Steiner</td><td>" . formatValue($info['steiner']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Otros</td><td>" . formatValue($info['others_analysis']) . "</td></tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table style='width: 100% !important; table-layout: fixed !important; border-spacing: 10px !important;'>
                <thead>
                    <th style='font-size: 12px'>
                        Radiografías Intraorales
                    </th>
                    <th></th>
                    <th style='font-size: 12px'>
                        Modelos de Estudio  
                    </th>
                    <th style='font-size: 12px'>
                        Estereolitografía (MAXILAR)
                    </th>
                </thead>
                <tr>
                    <td style='width: 25% !important; background-color: #f2f2f2 !important; padding: 10px !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table>
                            <tr style='font-size: 11px !important;'><td>Oclusal</td><td>" . formatValue($info['occlusal_xray']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Superior</td><td>" . formatValue($info['superior']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Inferior</td><td>" . formatValue($info['inferior']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Serie Periapical Completa</td><td>" . formatValue($info['complete_periapical']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Individual Periapical</td><td>" . formatValue($info['individual_periapical']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Conductometría</td><td>" . formatValue($info['conductometry']) . "</td></tr>
                        </table>
                    </td>
                    <td style='width: 30% !important; background-color: #f2f2f2 !important; padding: 10px !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <img src='" . $base64Cruze . "' width='200' height='80'>
                    </td>
                    <td style='width: 20% !important; background-color: #e0f7fa !important; padding: 10px !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table>
                            <tr style='font-size: 11px !important;'><td>Risina</td><td>" . formatValue($info['risina']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>DentalPrint</td><td>" . formatValue($info['dentalprint']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Impresión 3D Resina</td><td>" . formatValue($info['3d_risina']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Guía Quirúrgica</td><td>" . formatValue($info['surgical_guide']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Pieza de Estudio</td><td>" . formatValue($info['studio_piece']) . "</td></tr>
                        </table>
                    </td>
                    <td style='width: 20% !important; background-color: #f2f2f2 !important; padding: 10px !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table>
                            <tr style='font-size: 11px !important;'><td>Superior</td><td>" . formatValue($info['maxilar_superior']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Inferior</td><td>" . formatValue($info['maxilar_inferior']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Ambos</td><td>" . formatValue($info['maxilar_both']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Otros</td><td>" . formatValue($info['maxilar_others']) . "</td></tr>
                        </table>
                    </td>
                    
                </tr>
            </table>
            <table style='width: 100% !important; table-layout: fixed !important; border-spacing: 10px !important;'>
                <thead>
                    <th style='font-size: 12px'>Tomografía 3D</th>
                </thead>
                <tr>
                    <td style='width: 33.33% !important; background-color: #f2f2f2 !important; padding: 10px !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table>
                            <tr style='font-size: 11px !important;'><td>Tomografía Completa</td><td>" . formatValue($info['complete_tomography']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Tomografía Ambos Maxilares</td><td>" . formatValue($info['two_jaws_tomography']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Tomografía Maxilar</td><td>" . formatValue($info['maxilar_tomography']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Tomografía Mandíbula</td><td>" . formatValue($info['jaw_tomography']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Tomografía SNP</td><td>" . formatValue($info['snp_tomography']) . "</td></tr>
                        </table>
                    </td>
                    <td style='width: 33.33% !important; background-color: #f2f2f2 !important; padding: 10px !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table>
                            <tr style='font-size: 11px !important;'><td>Tomografría Oído</td><td>" . formatValue($info['ear_tomography']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Tomografía ATM Boca Abierta/Cerrada</td><td>" . formatValue($info['atm_tomography_open_close']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Tomografía ATM Boca Abierta</td><td>" . formatValue($info['lateral_left_tomography_open_close']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Tomografía ATM Boca Cerrada</td><td>" . formatValue($info['lateral_right_tomography_open_close']) . "</td></tr>
                        </table>
                    </td>
                    <td style='width: 33.33% !important; background-color: #f2f2f2 !important; padding: 10px !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table>
                            <tr style='font-size: 11px !important;'><td>ONDEMAND: </td><td>" . formatValue($info['ondemand']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>DICOM: </td><td>" . formatValue($info['dicom']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Pieza #: </td><td>" . formatValue($info['tomography_piece']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Diente Retenido: </td><td>" . formatValue($info['impacted_tooth']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Otros: </td><td>" . formatValue($info['others_tomography']) . "</td></tr>
                        </table>
                    </td>
                </tr>   
            </table>
            <table style='width: 100% !important; table-layout: fixed !important; border-spacing: 10px !important;'>
                <thead>
                    <th style='font-size: 12px'>Fotografía Clínica Intraoral y Extraoral</th>
                    <th style='font-size: 12px'>Tipo de Formato</th>
                    <th style='font-size: 12px'>Análisis de Modelo</th>
                    <th style='font-size: 12px'>Escaneo Intraoral</th>
                </thead>
                <tr>
                    <td style='width: 25% !important; background-color: #f2f2f2 !important; padding: 10px !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table>
                            <tr style='font-size: 11px !important;'><td>F.C.I. y Ext.</td><td>" . formatValue($info['clinical_photography']) . "</td></tr>
                        </table>
                    </td>
                    <td style='width: 25% !important; background-color: #e0f7fa !important; padding: 10px !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table>
                            <tr style='font-size: 11px !important;'><td>Acetato</td><td>" . formatValue($info['acetate_print']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Papel Backlight</td><td>" . formatValue($info['paper_print']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>E-mail</td><td>" . formatValue($info['send_email']) . "</td></tr>
                        </table>
                    </td>
                    <td style='width: 25% !important; background-color: #f2f2f2 !important; padding: 10px !important; border-radius: 1px !important; vertical-align: top !important;'>                
                        <table>
                            <tr style='font-size: 11px !important;'><td>Bolton</td><td>" . formatValue($info['analysis_bolton']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Moyers</td><td>" . formatValue($info['analysis_moyers']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>Otros</td><td>" . formatValue($info['others_models_analysis']) . "</td></tr>
                        </table>
                    </td>
                     <td style='width: 25% !important; background-color: #f2f2f2 !important; padding: 10px !important; border-radius: 1px !important; vertical-align: top !important;'>                
                        <table>
                            <tr style='font-size: 11px !important;'><td>STL</td><td>" . formatValue($info['stl']) . "</td><td style='font-size: 11px !important;'>Invisaligh</td><td>" . formatValue($info['invisaligh']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>OBJ</td><td>" . formatValue($info['obj']) . "</td><td style='font-size: 11px !important;'>Otros</td><td>" . formatValue($info['others_scanners']) . "</td></tr>
                            <tr style='font-size: 11px !important;'><td>PLY</td><td>" . formatValue($info['ply']) . "</td></tr>
                        </table>
                    </td>
                </tr>
            </table>
            <label style='font-size: 11px !important;'>Interpretación Odontológica: </label>" . formatValue($info['dental_interpretation']) . " 
            </div>
            <br>
            <label style='font-size: 11px !important;'>Otros:_________________________________________</label>
            <br>
            <center>
            <div>
            ____________________
            <br><label style='font-size: 11px !important;'>Firma</label>
            <div>
            
            <center>
        </body>
        </html>";

        // Cargar HTML en Dompdf
        $dompdf->loadHtml($html);

        // Configurar tamaño de papel y orientación
        $dompdf->setPaper('A4', 'portrait');

        // Renderizar el PDF
        $dompdf->render();
        $pdfOutput = $dompdf->output();
        $cleanCode = "";
        if ($info['code'] == 'sin-folio') {
            $cleanCode = $info['id'];
        } else {
            $cleanCode = preg_replace('/[^A-Za-z0-9_\-]/', '_', $info['code']);
        }

        // Ruta con nombre dinámico
        $filePath = 'docs/' . $cleanCode . '.pdf';

        // Guardar en el servidor
        file_put_contents($filePath, $pdfOutput);

        // Enviar encabezados al navegador para visualizar directamente
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($filePath) . '"');
        echo $pdfOutput;
        exit; // Importante para evitar cualquier salida extra
    }
}
