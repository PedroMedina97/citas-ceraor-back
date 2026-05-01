<?php

use Phinx\Migration\AbstractMigration;

class UpdateOrdersTableRemoveColumnsAndAddKartRelation extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('orders');
        
        // Eliminar todas las columnas no necesarias
        $columnsToRemove = [
            'rx_panoramic',
            'rx_arc_panoramic',
            'rx_lateral_skull',
            'ap_skull',
            'pa_skull',
            'paranasal_sinuses',
            'atm_open_close',
            'profilogram',
            'watters_skull',
            'palmar_digit',
            'others_radiography',
            'occlusal_xray',
            'superior',
            'inferior',
            'complete_periapical',
            'individual_periapical',
            'conductometry',
            'clinical_photography',
            'rickets',
            'mcnamara',
            'downs',
            'jaraback',
            'steiner',
            'others_analysis',
            'analysis_bolton',
            'analysis_moyers',
            'others_models_analysis',
            'risina',
            'dentalprint',
            '3d_risina',
            'surgical_guide',
            'studio_piece',
            'complete_tomography',
            'two_jaws_tomography',
            'maxilar_tomography',
            'jaw_tomography',
            'snp_tomography',
            'ear_tomography',
            'atm_tomography_open_close',
            'lateral_left_tomography_open_close',
            'lateral_right_tomography_open_close',
            'ondemand',
            'dicom',
            'tomography_piece',
            'implant',
            'impacted_tooth',
            'others_tomography',
            'stl',
            'obj',
            'ply',
            'invisaligh',
            'others_scanners',
            'maxilar_superior',
            'maxilar_inferior',
            'maxilar_both',
            'maxilar_others',
            'dental_interpretation'
        ];
        
        foreach ($columnsToRemove as $column) {
            $table->removeColumn($column);
        }
        
        // Agregar la columna id_kart con foreign key a karts
        $table->addColumn('id_kart', 'string', ['limit' => 255, 'null' => true, 'after' => 'id'])
              ->addForeignKey('id_kart', 'karts', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION', 'constraint' => 'fk_orders_kart'])
              ->update();
    }
}
