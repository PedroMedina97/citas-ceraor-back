<?php

use Phinx\Migration\AbstractMigration;

class CreateSubsidiariesServicesTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('subsidiaries_services', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('id_subsidiary', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('id_service', 'string', ['limit' => 255, 'null' => true])
              ->addForeignKey('id_subsidiary', 'subsidiaries', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION', 'constraint' => 'fk_subsidiaries_services_subsidiary'])
              ->addForeignKey('id_service', 'services', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION', 'constraint' => 'fk_subsidiaries_services_service'])
              ->create();
    }
}
