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
            <style>$bootstrapCSS</style>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                    padding: 10px;
                }
                h1 {
                    text-align: center;
                    color: #2C3E50;
                    margin-bottom: 20px;
                }
                .section-title {
                    font-size: 16px;
                    font-weight: bold;
                    margin-top: 20px;
                    border-bottom: 2px solid #007BFF;
                    padding-bottom: 5px;
                    margin-bottom: 10px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 10px;
                }
                th, td {
                    border: 1px solid #ddd;
                    padding: 6px;
                    text-align: left;
                    font-size: 12px;
                }
                th {
                    background-color: #007BFF;
                    color: white;
                }
                .container {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: space-between;
                }
                .column {
                    width: 48%;
                }
            </style>
        </head>
        <body>
            <h1>ORDEN DE ESTUDIOS</h1>
            <div class='container'>

                <!-- Datos del Paciente y Médico -->
                <div class='column'>
                    <div class='section-title'>Datos del Paciente</div>
                    <table>
                        <tr><th>Paciente</th><td>" . formatValue($info['patient']) . "</td></tr>
                        <tr><th>Fecha de Nacimiento</th><td>" . formatValue($info['birthdate']) . "</td></tr>
                        <tr><th>Teléfono</th><td>" . formatValue($info['phone']) . "</td></tr>
                        <tr><th>Dirección</th><td>" . formatValue($info['address']) . "</td></tr>
                        <tr><th>E-mail</th><td>" . formatValue($info['email']) . "</td></tr>
                    </table>

                    <div class='section-title'>Datos del Médico</div>
                    <table>
                        <tr><th>Doctor</th><td>" . formatValue($info['doctor']) . "</td></tr>
                        <tr><th>Cédula Profesional</th><td>" . formatValue($info['professional_id']) . "</td></tr>
                    </table>
                </div>

                <!-- Radiografías, Tomografías y Análisis -->
                <div class='column'>
                    <div class='section-title'>Radiografías</div>
                    <label>Impresión Acetato: </label>" . formatValue($info['acetate_print']) ."<br>"."
                    <label>Impresión Papel Backlight Blanco: </label>" . formatValue($info['paper_print']) ."<br>"."
                    <label>E-mail: </label>" . formatValue($info['send_email']) ."<br>"."
                    <table>
                        <tr><th>Estudio</th><th>Estado</th></tr>
                        <tr><td>Rx Panorámica</td><td>" . formatValue($info['rx_panoramic']) . "</td></tr>
                        <tr><td>Rx Arcada Panorámica</td><td>" . formatValue($info['rx_arc_panoramic']) . "</td></tr>
                        <tr><td>Rx Lateral de Cráneo</td><td>" . formatValue($info['rx_lateral_skull']) . "</td></tr>
                        <tr><td>Rx AP Cráneo</td><td>" . formatValue($info['ap_skull']) . "</td></tr>
                        <tr><td>Rx PA Cráneo</td><td>" . formatValue($info['pa_skull']) . "</td></tr>
                        <tr><td>Senos Paranasales</td><td>" . formatValue($info['paranasal_sinuses']) . "</td></tr>
                        <tr><td>ATM Apertura y Cierre</td><td>" . formatValue($info['atm_open_close']) . "</td></tr>
                        <tr><td>Perfilograma</td><td>" . formatValue($info['profilogram']) . "</td></tr>
                        <tr><td>Cráneo de Watters</td><td>" . formatValue($info['watters_skull']) . "</td></tr>
                        <tr><td>Palmar y Digitales</td><td>" . formatValue($info['palmar_digit']) . "</td></tr>
                        <tr><td>Otros</td><td>" . formatValue($info['others_radiography']) . "</td></tr>
                    </table>

                    <div class='section-title'>Análisis Cefalométricos</div>
                    <table>
                        <tr><td>Rickets</td><td>" . formatValue($info['rickets']) . "</td></tr>
                        <tr><td>McNamara</td><td>" . formatValue($info['mcnamara']) . "</td></tr>
                        <tr><td>Downs</td><td>" . formatValue($info['downs']) . "</td></tr>
                        <tr><td>Jaraback</td><td>" . formatValue($info['jaraback']) . "</td></tr>
                        <tr><td>Steiner</td><td>" . formatValue($info['steiner']) . "</td></tr>
                        <tr><td>Otros</td><td>" . formatValue($info['others_analysis']) . "</td></tr>
                    </table>
                </div>
                <div class='section-title'>Análisis de Modelo</div>
                <table>
                    <tr><td>Bolton</td><td>" . formatValue($info['analysis_bolton']) . "</td></tr>
                    <tr><td>Moyers</td><td>" . formatValue($info['analysis_moyers']) . "</td></tr>
                    <tr><td>Otros</td><td>" . formatValue($info['others_models_analysis']) . "</td></tr>
                </table>
                </div>
                <div class='section-title'>Radiografías Intraorales</div>
                    <table>
                        <tr><td>Oclusal</td><td>" . formatValue($info['occlusal_xray']) . "</td></tr>
                        <tr><td>Superior</td><td>" . formatValue($info['superior']) . "</td></tr>
                        <tr><td>Inferior</td><td>" . formatValue($info['inferior']) . "</td></tr>
                    </table>
                </div>
                <!-- Otros Servicios y Datos Adicionales -->
                <div class='column' style='width: 100%; margin-top: 20px;'>
                    <div class='section-title'>Otros Servicios</div>
                    <table>
                        <tr><th>Servicio</th><th>Estado</th></tr>
                        <tr><td>DentalPrint</td><td>" . formatValue($info['dentalprint']) . "</td></tr>
                        <tr><td>Impresión 3D Resina</td><td>" . formatValue($info['3d_risina']) . "</td></tr>
                        <tr><td>Guía Quirúrgica</td><td>" . formatValue($info['surgical_guide']) . "</td></tr>
                        <tr><td>Pieza de Estudio</td><td>" . formatValue($info['studio_piece']) . "</td></tr>
                        <tr><td>Conductometría</td><td>" . formatValue($info['conductometry']) . "</td></tr>
                        <tr><td>Fotografía Clínica</td><td>" . formatValue($info['clinical_photography']) . "</td></tr>
                    </table>
                </div>
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
