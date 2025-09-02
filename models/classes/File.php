<?php

namespace Classes;

use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class File
{
    public static function generatePDF(array $dataPDF, string $disposition = 'inline')
    {
        // Validar que el array no esté vacío
        if (empty($dataPDF) || !isset($dataPDF[0])) {
            throw new \Exception("No se encontraron datos para generar el PDF");
        }

        $info = $dataPDF[0];
        
        // Validar que $info sea un array
        if (!is_array($info)) {
            throw new \Exception("Los datos proporcionados no tienen el formato correcto");
        }
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $bootstrapCSS = file_get_contents('vendor/twbs/bootstrap/dist/css/bootstrap.min.css');
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

        // Verificar si existe barcode y el archivo existe
        if (is_array($info) && 
            array_key_exists('barcode', $info) && 
            !empty($info['barcode']) && 
            $info['barcode'] !== 'N/A' && 
            file_exists("appointments-barcodes/" . $info['barcode'])) {
            
            // Usar el código de barras existente
            $pathBarcode = "appointments-barcodes/" . $info['barcode'];
            $typeBarcode = pathinfo($pathBarcode, PATHINFO_EXTENSION);
            $dataBarcode = file_get_contents($pathBarcode);
            $base64Barcode = 'data:image/' . $typeBarcode . ';base64,' . base64_encode($dataBarcode);
        } else {
            // Usar imagen de sin-folio cuando:
            // - No hay barcode
            // - El barcode es 'N/A' (valor por defecto)
            // - El archivo del barcode no existe
            $pathBarcode = "assets/images/sin-folio.png";
            $typeBarcode = pathinfo($pathBarcode, PATHINFO_EXTENSION);
            
            // Verificar que el archivo sin-folio existe
            if (file_exists($pathBarcode)) {
                $dataBarcode = file_get_contents($pathBarcode);
                $base64Barcode = 'data:image/' . $typeBarcode . ';base64,' . base64_encode($dataBarcode);
            } else {
                // Fallback si sin-folio.png tampoco existe
                $base64Barcode = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg=='; // 1x1 transparent pixel
            }
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

                    <th style='font-size: 11px'>Veracruz, Ver.</th>
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

                    <td style='background-color: #f2f2f2 !important; border-radius: 1px !important; vertical-align: top !important;'>

                        <table>

                            <tr>

                                <td style='font-size: 10px'><b>Dirección: </b>Calle España No.23, Fracc. Reforma, 91919, Veracruz, Ver.</td>

                            </tr>

                            <tr>

                                <td style='font-size: 10px'><b>Teléfono(s): </b>229-935-9472, 229-489-1442</td>

                            </tr>

                            <tr>

                                <td style='font-size: 10px'><b>WhatsApp: </b> 229-117-9108</td>

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

                            <tr style='font-size: 11px !important;'><td>Watters de Cráneo </td><td>" . formatValue($info['watters_skull']) . "</td></tr>

                            <tr style='font-size: 11px !important;'><td>Dígito Palmar (Carpal) </td><td>" . formatValue($info['palmar_digit']) . "</td></tr>

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

                            <tr style='font-size: 11px !important;'><td>Resina</td><td>" . formatValue($info['risina']) . "</td></tr>

                            <tr style='font-size: 11px !important;'><td>DentalPrint</td><td>" . formatValue($info['dentalprint']) . "</td></tr>

                            <tr style='font-size: 11px !important;'><td>Impresión 3D Resina</td><td>" . formatValue($info['3d_risina']) . "</td></tr>

                            <tr style='font-size: 11px !important;'><td>Guía Quirúrgica</td><td>" . formatValue($info['surgical_guide']) . "</td></tr>

                            <tr style='font-size: 11px !important;'><td>Pieza: </td><td>" . formatValue($info['studio_piece']) . "</td></tr>

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

                            <tr style='font-size: 11px !important;'><td>STL</td><td>" . formatValue($info['stl']) . "</td><td style='font-size: 11px !important;'>Invisalign</td><td>" . formatValue($info['invisaligh']) . "</td></tr>

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
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfOutput = $dompdf->output();
        $cleanCode = "";
        if ($info['code'] == 'sin-folio') {
            $cleanCode = $info['id'];
        } else {
            $cleanCode = preg_replace('/[^A-Za-z0-9_\-]/', '_', $info['code']);
        }
        $filePath = 'docs/' . $cleanCode . '.pdf';
        file_put_contents($filePath, $pdfOutput);
        header('Content-Type: application/pdf');
        header('Content-Disposition: ' . $disposition . '; filename="' . basename($filePath) . '"');
        echo $pdfOutput;
        exit; // Importante para evitar cualquier salida extra

    }

    /**
     * Generar PDF de etiqueta/ticket para órdenes
     * @param array $dataTicket Datos de la orden para generar la etiqueta
     * @return void
     */
    public static function generateTicketPDF(array $dataTicket, string $disposition = 'inline')
    {
        // Validar que el array no esté vacío
        if (empty($dataTicket) || !isset($dataTicket[0])) {
            throw new \Exception("No se encontraron datos para generar la etiqueta");
        }

        $info = $dataTicket[0];
        
        // Validar que $info sea un array
        if (!is_array($info)) {
            throw new \Exception("Los datos proporcionados para la etiqueta no tienen el formato correcto");
        }
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Cargar logo de la empresa
        $logoPath = 'assets/images/logo_ceraor.png';
        $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
        $logoData = file_get_contents($logoPath);
        $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);

        // Valores por defecto para campos faltantes
        $orderId = $info['id_orden'] ?? 'N/A';
        $ticketCode = $info['code_ticket'] ?? null;
        $patientName = $info['nombre_paciente'] ?? 'N/A';
        $doctorName = $info['nombre_doctor'] ?? 'N/A';
        $phone = $info['telefono_contacto'] ?? 'N/A';
        $service = $info['servicio'] ?? 'Estudio radiológico';
        $method = $info['metodo'] ?? 'por_definir';
        $status = $info['status'] ?? 'solicitado';
        $updateDate = isset($info['fecha_actualizacion']) ? date('d/m/Y H:i', strtotime($info['fecha_actualizacion'])) : date('d/m/Y H:i');
        
        // Priorizar code_ticket sobre ID de orden
        if (!empty($ticketCode)) {
            $displayCode = $ticketCode;
        } else {
            $displayCode = $orderId;
        }

        // Mapear método a texto legible
        $methodText = [
            'fisico' => 'Físico',
            'digital' => 'Digital', 
            'ambos' => 'Físico y Digital',
            'por_definir' => 'Por definir'
        ];
        $methodDisplay = $methodText[$method] ?? ucfirst($method);
        
        // Mapear status a texto legible
        $statusText = [
            'solicitado' => 'Solicitado',
            'en_proceso' => 'En Proceso',
            'entregado' => 'Entregado'
        ];
        $statusDisplay = $statusText[$status] ?? ucfirst($status);

        // HTML para la etiqueta - Formato horizontal simplificado
        $html = "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <title>Etiqueta {$displayCode}</title>
            <style>
                body { 
                    margin: 0; 
                    padding: 20px; 
                    font-family: Arial, sans-serif; 
                    font-size: 16px;
                    line-height: 1.5;
                    color: #000;
                    height: 100vh;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                }
                .ticket {
                    width: 100%;
                    max-width: 500px;
                    margin: 0 auto;
                    border: 2px solid #000;
                    padding: 30px;
                    box-sizing: border-box;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }
                .header-section {
                    text-align: center;
                    margin-bottom: 30px;
                    padding-bottom: 20px;
                    border-bottom: 2px solid #000;
                    width: 100%;
                }
                .logo {
                    max-width: 100px;
                    height: auto;
                    margin-bottom: 10px;
                }
                .company {
                    font-size: 24px;
                    font-weight: bold;
                    color: #000;
                    margin-bottom: 5px;
                }
                .subtitle {
                    font-size: 14px;
                    color: #666;
                    margin-bottom: 10px;
                }
                .info-section {
                    width: 100%;
                    max-width: 400px;
                }
                .info-row {
                    display: flex;
                    margin-bottom: 15px;
                    padding: 10px;
                    background-color: #f9f9f9;
                    border-radius: 5px;
                    align-items: center;
                }
                .label {
                    font-weight: bold;
                    width: 120px;
                    font-size: 14px;
                    color: #333;
                }
                .value {
                    font-size: 16px;
                    color: #000;
                    flex: 1;
                }
            </style>
        </head>
        <body>
            <div class='ticket'>
                <div class='header-section'>
                    <img src='{$logoBase64}' class='logo'>
                    <div class='company'>CERAOR</div>
                    <div class='subtitle'>Centro de Radiología Oral y Maxilofacial</div>
                </div>
                
                <div class='info-section'>
                    <div class='info-row'>
                        <span class='label'>Paciente:</span>
                        <span class='value'>{$patientName}</span>
                    </div>
                    
                    <div class='info-row'>
                        <span class='label'>Doctor:</span>
                        <span class='value'>{$doctorName}</span>
                    </div>
                    
                    <div class='info-row'>
                        <span class='label'>Teléfono:</span>
                        <span class='value'>{$phone}</span>
                    </div>
                    
                    <div class='info-row'>
                        <span class='label'>Servicio:</span>
                        <span class='value'>{$service}</span>
                    </div>
                    
                    <div class='info-row'>
                        <span class='label'>Fecha:</span>
                        <span class='value'>{$updateDate}</span>
                    </div>
                </div>
            </div>
        </body>
        </html>";

        // Configurar y generar PDF
        $dompdf->loadHtml($html);
        
        // Formato A4 vertical (toda la hoja)
        $dompdf->setPaper('A4', 'portrait');
        
        $dompdf->render();
        $pdfOutput = $dompdf->output();

        // Nombre del archivo usando código de ticket si existe
        $cleanCode = preg_replace('/[^A-Za-z0-9_\-]/', '_', $displayCode);
        
        // Crear carpeta si no existe
        $ticketsDir = 'docs/tickets';
        if (!is_dir($ticketsDir)) {
            mkdir($ticketsDir, 0755, true);
        }
        
        $filePath = $ticketsDir . '/ticket_' . $cleanCode . '.pdf';
        
        // Guardar archivo
        file_put_contents($filePath, $pdfOutput);

        // Enviar al navegador
        header('Content-Type: application/pdf');
        header('Content-Disposition: ' . $disposition . '; filename="ticket_' . $cleanCode . '.pdf"');
        echo $pdfOutput;
        exit;
    }

    public static function generateCashCutPDF(array $info)
    {
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $bootstrapCSS = file_get_contents('vendor/twbs/bootstrap/dist/css/bootstrap.min.css');
        $path = 'assets/images/logo_ceraor.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $fecha = date('d/m/Y H:i');
        $usuario = $info['usuario_corte'];
        $sucursal = $info['sucursal'];
        $movimientos = $info['movimientos'];
        $id_corte = $info['id_corte'];

        $total = 0;
        $tabla = "
            <style>
                th, td {
                    font-size: 12px;
                    padding: 6px !important;
                    vertical-align: middle !important;
                }
                .table-total {
                    font-weight: bold;
                    background-color: #f8f9fa;
                }
            </style>
            <table class='table table-bordered table-hover mt-4'>
                <thead class='table-dark text-center'>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Servicio</th>
                        <th>Método de Pago</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>";

        foreach ($movimientos as $index => $m) {
            $total += $m['monto'];
            $tabla .= "
                    <tr>
                        <td class='text-center'>" . ($index + 1) . "</td>
                        <td>{$m['cliente']}</td>
                        <td>{$m['servicio']}</td>
                        <td>{$m['metodo_pago']}</td>
                        <td class='text-end'>$" . number_format($m['monto'], 2) . "</td>
                        <td>" . date('d/m/Y H:i', strtotime($m['fecha_pago'])) . "</td>
                    </tr>";
        }

        $tabla .= "
                <tr class='table-total'>
                    <td colspan='4' class='text-end'>Total</td>
                    <td class='text-end'>$" . number_format($total, 2) . "</td>
                    <td></td>
                </tr>";

        $tabla .= "</tbody></table>";


        $html = "
                <!DOCTYPE html>
                <html lang='es'>
                <head>
                    <meta charset='UTF-8'>
                    <title>Corte de Caja</title>
                    <style>{$bootstrapCSS}</style>
                </head>
                <body>
                    <table style='width: 100%; margin-bottom: 20px;'>
                        <tr>
                            <td style='width: 50%;'>
                                <img src='" . $base64 . "' width='100' height='100'>
                            </td>
                            <td style='width: 50%; text-align: right;'>
                                <p><strong>Fecha de generación:</strong> {$fecha}</p>
                                <p><strong>Sucursal:</strong> {$sucursal}</p>
                                <p><strong>Usuario:</strong> {$usuario}</p>
                                <p><strong>ID Corte:</strong> {$id_corte}</p>
                            </td>
                        </tr>
                    </table>
                    <h4 class='text-center'>Movimientos del Corte</h4>
                    {$tabla}
                </body>
                </html>";

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $pdfOutput = $dompdf->output();
        $filePath = "docs/cashcuts/{$id_corte}.pdf";

        file_put_contents($filePath, $pdfOutput);

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($filePath) . '"');
        echo $pdfOutput;
        exit;
    }

    public static function generateCashCutExcel(array $info)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $usuario = $info['usuario_corte'];
        $sucursal = $info['sucursal'];
        $movimientos = $info['movimientos'];
        $id_corte = $info['id_corte'];
        $fecha = date('d/m/Y H:i');

        // Encabezados del reporte
        $sheet->setCellValue('A1', 'Corte de Caja');
        $sheet->setCellValue('A2', "ID del Corte: $id_corte");
        $sheet->setCellValue('A3', "Usuario: $usuario");
        $sheet->setCellValue('A4', "Sucursal: $sucursal");
        $sheet->setCellValue('A5', "Fecha de generación: $fecha");

        // Encabezados de tabla
        $headers = ['#', 'Cliente', 'Servicio', 'Método de Pago', 'Monto', 'Fecha de Pago'];
        $sheet->fromArray($headers, null, 'A7');

        // Datos
        $rowIndex = 8;
        $total = 0;

        foreach ($movimientos as $index => $m) {
            $sheet->setCellValue("A$rowIndex", $index + 1);
            $sheet->setCellValue("B$rowIndex", $m['cliente']);
            $sheet->setCellValue("C$rowIndex", $m['servicio']);
            $sheet->setCellValue("D$rowIndex", $m['metodo_pago']);
            $sheet->setCellValue("E$rowIndex", $m['monto']);
            $sheet->setCellValue("F$rowIndex", date('d/m/Y H:i', strtotime($m['fecha_pago'])));
            $total += $m['monto'];
            $rowIndex++;
        }

        // Fila de total
        $sheet->setCellValue("D$rowIndex", 'Total');
        $sheet->setCellValue("E$rowIndex", $total);

        // Estilos básicos
        $sheet->getStyle("A7:F7")->getFont()->setBold(true);
        $sheet->getStyle("A7:F$rowIndex")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);

        // Nombre y guardado
        $filename = "docs/cashcuts/" . $id_corte . ".xlsx";

        if (ob_get_length()) ob_end_clean();

        // Cabeceras para descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output'); // salida directa al navegador
        exit;
    }

    public static function exportCashCutsRangeToExcel(array $groupedCuts)
    {
        $spreadsheet = new Spreadsheet();

        $nombreSucursal = ''; // ← la tomaremos del primer corte
        foreach ($groupedCuts as $index => $corte) {
            $sheet = $index === 0
                ? $spreadsheet->getActiveSheet()
                : $spreadsheet->createSheet();

            $sheet->setTitle(substr($corte['id_corte'], 0, 20));

            // Guardar el nombre de la sucursal (solo el primero, todos son iguales)
            if ($index === 0) {
                $nombreSucursal = preg_replace('/[^a-zA-Z0-9_-]/', '', str_replace(' ', '_', $corte['sucursal']));
            }

            // Encabezados de corte
            $sheet->setCellValue('A1', 'ID del Corte: ' . $corte['id_corte']);
            $sheet->setCellValue('A2', 'Usuario: ' . $corte['usuario']);
            $sheet->setCellValue('A3', 'Sucursal: ' . $corte['sucursal']);
            $sheet->setCellValue('A4', 'Fecha de Inicio: ' . $corte['start_date']);
            $sheet->setCellValue('A5', 'Fecha de Fin: ' . $corte['end_date']);

            // Encabezado tabla
            $headers = ['#', 'Cliente', 'Servicio', 'Método de Pago', 'Monto', 'Fecha de Pago'];
            $sheet->fromArray($headers, null, 'A7');

            $row = 8;
            $total = 0;
            foreach ($corte['pagos'] as $i => $pago) {
                $sheet->setCellValue("A$row", $i + 1);
                $sheet->setCellValue("B$row", $pago['cliente']);
                $sheet->setCellValue("C$row", $pago['servicio']);
                $sheet->setCellValue("D$row", $pago['metodo_pago']);
                $sheet->setCellValue("E$row", $pago['monto']);
                $sheet->setCellValue("F$row", date('d/m/Y H:i', strtotime($pago['fecha_pago'])));
                $total += $pago['monto'];
                $row++;
            }

            // Total
            $sheet->setCellValue("D$row", 'Total');
            $sheet->setCellValue("E$row", $total);

            // Estilos
            $sheet->getStyle("A7:F7")->getFont()->setBold(true);
            $sheet->getStyle("A7:F$row")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        }

        // Crear nombre y ruta con sucursal
        $fileName = "cortes_{$nombreSucursal}_" . date('Ymd_His') . '.xlsx';
        $filePath = 'docs/cashcuts/' . $fileName;

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        if (ob_get_length()) ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header('Cache-Control: max-age=0');
        readfile($filePath);
        exit;
    }
}
