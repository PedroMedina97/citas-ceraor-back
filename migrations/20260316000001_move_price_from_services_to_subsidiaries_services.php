<?php

use Phinx\Migration\AbstractMigration;

class MovePriceFromServicesToSubsidiariesServices extends AbstractMigration
{
    public function change()
    {
        // 1. Agregar columna price a subsidiaries_services
        $subsidiaries_services_table = $this->table('subsidiaries_services');
        $subsidiaries_services_table->addColumn('price', 'float', ['null' => false, 'default' => 0.00, 'after' => 'id_service'])
            ->update();

        // 2. Remover columna price de services
        $services_table = $this->table('services');
        $services_table->removeColumn('price')
            ->update();
    }
}
