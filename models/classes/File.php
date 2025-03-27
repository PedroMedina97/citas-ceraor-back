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

    public static function generatePDF(array $info)
    {
        // Configurar Dompdf
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
            return ($value === 1) ? "<span style='text-decoration: underline;'>Sí</span>" : ($value === 0 ? "No" : $value);
        }

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
            <h3>ORDEN DE ESTUDIOS</h3>
            <table style='width: 100% !important; table-layout: fixed !important; border-spacing: 10px !important;'>
           
                <thead>
                    <th><div class='section-title'>Datos del Paciente</div></th>
                    <th></th>
                    <th><div class='section-title'>Datos del Doctor</div></th>
                </thead>
                <tr>
                <td style='width: 40% !important; background-color: #f2f2f2 !important; padding: 20px !important; border-radius: 1px !important; vertical-align: top !important;'>
                    <table>
                            <tr>
                                <th>Paciente</th>
                                <td>" . formatValue($info['patient']) . "</td>
                            </tr>
                            <tr>
                                <th>Fecha de Nacimiento</th>
                                <td>" . formatValue($info['birthdate']) . "</td>
                            </tr>
                            
                            
                        </table>
                </td>
                <td style='width: 30% !important; background-color: #f2f2f2 !important; padding: 20px !important; border-radius: 1px !important; vertical-align: top !important;'>
                    <table>
                    <tr>
                                <th>Dirección</th>
                                <td>" . formatValue($info['address']) . "</td>
                            </tr>
                            <tr>
                                <th>E-mail</th>
                                <td>" . formatValue($info['email']) . "</td>
                            </tr>
                            <tr>
                                <th>Teléfono</th>
                                <td>" . formatValue($info['phone']) . "</td>
                            </tr>
                    </table>
                </td>
                <td style='width: 30% !important; background-color: #e0f7fa !important; padding: 20px !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table>
                            <tr>
                                <th>Doctor</th>
                                <td>" . formatValue($info['doctor']) . "</td>
                            </tr>
                            <tr>
                                <th>Cédula Profesional</th>
                                <td>" . formatValue($info['professional_id']) . "</td>
                            </tr>
                        </table>
                </td>
                </tr>
            </table>
            <table style='width: 100% !important; table-layout: fixed !important; border-spacing: 10px !important;'>
                <thead>
                    <th>
                        <div class='section-title'>
                            <div class='section-title'>Radiografías</div>
                        </div>
                    </th>
                    <th>
                        <div class='section-title'>
                            <div class='section-title'>Análisis Cefalométricos</div>
                        </div>
                    </th>  
                </thead>
                <tr>
                    <td style='width: 70% !important; background-color: #f2f2f2 !important; padding: 20px !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table>
                            <tr><td>Rx Panorámica </td><td>" . formatValue($info['rx_panoramic']) . "</td><td>ATM Apertura y Cierre </td><td>" . formatValue($info['atm_open_close']) . "</td></tr>
                            <tr><td>Rx Arcada Panorámica </td><td>" . formatValue($info['rx_arc_panoramic']) . "</td><td>Perfilograma </td><td>" . formatValue($info['profilogram']) . "</td></tr>
                            <tr><td>Rx Lateral de Cráneo </td><td>" . formatValue($info['rx_lateral_skull']) . "</td><td>Cráneo de Watters </td><td>" . formatValue($info['watters_skull']) . "</td></tr>
                            <tr><td>Rx AP Cráneo </td><td>" . formatValue($info['ap_skull']) . "</td><td>Palmar y Digitales </td><td>" . formatValue($info['palmar_digit']) . "</td></tr>
                            <tr><td>Rx PA Cráneo </td><td>" . formatValue($info['pa_skull']) . "</td><td>Otros </td><td>" . formatValue($info['others_radiography']) . "</td></tr>
                            <tr><td>Senos Paranasales </td><td>" . formatValue($info['paranasal_sinuses']) . "</td></tr>
                        </table>
                    </td>
                    <td style='width: 30% !important; background-color: #e0f7fa !important; padding: 20px !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table>
                            <tr><td>Rickets</td><td>" . formatValue($info['rickets']) . "</td></tr>
                            <tr><td>McNamara</td><td>" . formatValue($info['mcnamara']) . "</td></tr>
                            <tr><td>Downs</td><td>" . formatValue($info['downs']) . "</td></tr>
                            <tr><td>Jaraback</td><td>" . formatValue($info['jaraback']) . "</td></tr>
                            <tr><td>Steiner</td><td>" . formatValue($info['steiner']) . "</td></tr>
                            <tr><td>Otros</td><td>" . formatValue($info['others_analysis']) . "</td></tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table style='width: 100% !important; table-layout: fixed !important; border-spacing: 10px !important;'>
                <thead>
                    <th>
                        <div class='section-title'>
                            <div class='section-title'>Radiografías Intraorales</div>
                        </div>
                    </th>
                    <th>
                        <div class='section-title'>
                            <div class='section-title'>Modelos de Estudio</div>
                        </div>
                    </th>
                    <th>
                        <div class='section-title'>
                            <div class='section-title'>Estereolitografía (MAXILAR)</div>
                        </div>
                    </th>
                </thead>
                <tr>
                    <td style='width: 33.33% !important; background-color: #f2f2f2 !important; padding: 20px !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table>
                            <tr><td>Oclusal</td><td>" . formatValue($info['occlusal_xray']) . "</td></tr>
                            <tr><td>Superior</td><td>" . formatValue($info['superior']) . "</td></tr>
                            <tr><td>Inferior</td><td>" . formatValue($info['inferior']) . "</td></tr>
                            <tr><td>Serie Periapical Completa</td><td>" . formatValue($info['complete_periapical']) . "</td></tr>
                            <tr><td>Individual Periapical</td><td>" . formatValue($info['individual_periapical']) . "</td></tr>
                            <tr><td>Conductometría</td><td>" . formatValue($info['conductometry']) . "</td></tr>
                        </table>
                    </td>
                    <td style='width: 33.33% !important; background-color: #e0f7fa !important; padding: 20px !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table>
                            <tr><td>Risina</td><td>" . formatValue($info['risina']) . "</td></tr>
                            <tr><td>DentalPrint</td><td>" . formatValue($info['dentalprint']) . "</td></tr>
                            <tr><td>Impresión 3D Resina</td><td>" . formatValue($info['3d_risina']) . "</td></tr>
                            <tr><td>Guía Quirúrgica</td><td>" . formatValue($info['surgical_guide']) . "</td></tr>
                            <tr><td>Pieza de Estudio</td><td>" . formatValue($info['studio_piece']) . "</td></tr>
                        </table>
                    </td>
                    <td style='width: 33.33% !important; background-color: #f2f2f2 !important; padding: 20px !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table>
                            <tr><td>Superior</td><td>" . formatValue($info['maxilar_superior']) . "</td></tr>
                            <tr><td>Inferior</td><td>" . formatValue($info['maxilar_inferior']) . "</td></tr>
                            <tr><td>Ambos</td><td>" . formatValue($info['maxilar_both']) . "</td></tr>
                            <tr><td>Otros</td><td>" . formatValue($info['maxilar_others']) . "</td></tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table style='width: 100% !important; table-layout: fixed !important; border-spacing: 10px !important;'>
                <thead>
                    <th><div class='section-title'>Tomografía 3D</div></th>
                </thead>
                <tr>
                    <td style='width: 75% !important; background-color: #f2f2f2 !important; padding: 20px !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table>
                            <tr><td>Tomografía Completa</td><td>" . formatValue($info['complete_tomography']) . "</td><td>Tomografría Oído</td><td>" . formatValue($info['ear_tomography']) . "</td></tr>
                            <tr><td>Tomografía Ambos Maxilares</td><td>" . formatValue($info['two_jaws_tomography']) . "</td><td>Tomografía ATM Boca Abierta/Cerrada</td><td>" . formatValue($info['atm_tomography_open_close']) . "</td></tr>
                            <tr><td>Tomografía Maxilar</td><td>" . formatValue($info['maxilar_tomography']) . "</td><td>Tomografía ATM Boca Abierta</td><td>" . formatValue($info['lateral_left_tomography_open_close']) . "</td></tr>
                            <tr><td>Tomografía Mandíbula</td><td>" . formatValue($info['jaw_tomography']) . "</td><td>Tomografía ATM Boca Cerrada</td><td>" . formatValue($info['lateral_right_tomography_open_close']) . "</td></tr>
                            <tr><td>Tomografía SNP</td><td>" . formatValue($info['snp_tomography']) . "</td></tr>
                        </table>
                    </td>
                    <td style='width: 25% !important; background-color: #f2f2f2 !important; padding: 20px !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table>
                            <tr><td>ONDEMAND</td><td>" . formatValue($info['ondemand']) . "</td></tr>
                            <tr><td>DICOM</td><td>" . formatValue($info['dicom']) . "</td></tr>
                            <tr><td>Pieza #</td><td>" . formatValue($info['tomography_piece']) . "</td></tr>
                            <tr><td>Diente Retenido</td><td>" . formatValue($info['impacted_tooth']) . "</td></tr>
                            <tr><td>Otros: </td><td>" . formatValue($info['others_tomography']) . "</td></tr>
                        </table>
                    </td>
                </tr>
               
                    
                
            </table>
            <table style='width: 100% !important; table-layout: fixed !important; border-spacing: 10px !important;'>
                <thead>
                    <th><div class='section-title'>Fotografía Clínica Intraoral y Extraoral</div></th>
                    <th><div class='section-title'>Tipo de Formato</div></th>
                    <th><div class='section-title'>Análisis de Modelo</div></th>
                </thead>
                <tr>
                    <td style='width: 33.33% !important; background-color: #f2f2f2 !important; padding: 20px !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table>
                            <tr><td>Fotografía Clínica Intraoral y Extraoral</td><td>" . formatValue($info['clinical_photography']) . "</td></tr>
                        </table>
                    </td>
                    <td style='width: 33.33% !important; background-color: #e0f7fa !important; padding: 20px !important; border-radius: 1px !important; vertical-align: top !important;'>
                        <table>
                            <tr><td>Impresión  Acetato</td><td>" . formatValue($info['acetate_print']) . "</td></tr>
                            <tr><td>Impresión Papel Backlight Blanco</td><td>" . formatValue($info['paper_print']) . "</td></tr>
                            <tr><td>E-mail</td><td>" . formatValue($info['send_email']) . "</td></tr>
                        </table>
                    </td>
                    <td style='width: 33.33% !important; background-color: #f2f2f2 !important; padding: 20px !important; border-radius: 1px !important; vertical-align: top !important;'>                
                        <table>
                            <tr><td>Bolton</td><td>" . formatValue($info['analysis_bolton']) . "</td></tr>
                            <tr><td>Moyers</td><td>" . formatValue($info['analysis_moyers']) . "</td></tr>
                            <tr><td>Otros</td><td>" . formatValue($info['others_models_analysis']) . "</td></tr>
                        </table>
                    </td>
                </tr>
            </table>
            
            </div>
        </body>
        </html>";

        // Cargar HTML en Dompdf
        $dompdf->loadHtml($html);

        // Configurar tamaño de papel y orientación
        $dompdf->setPaper('A4', 'portrait');

        // Renderizar el PDF
        $dompdf->render();
        $pdfOutput = $dompdf->output();

        // Ruta donde se guardará el PDF
        $filePath = 'docs/reporte.pdf';

        // Guardar en el servidor
        file_put_contents($filePath, $pdfOutput);

        // Retornar la ruta para descargar el archivo
        return $filePath;
    }
}
