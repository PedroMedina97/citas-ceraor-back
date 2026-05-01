<?php

use Phinx\Migration\AbstractMigration;

class CreateServicesTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('services', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('name', 'string', ['limit' => 100])
              ->addColumn('id_subsidiary', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('description', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('inputs', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('price', 'float')
              ->addColumn('active', 'integer', ['null' => true])
              ->addColumn('created_at', 'date')
              ->addColumn('updated_at', 'date')
              ->addForeignKey('id_subsidiary', 'subsidiaries', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION', 'constraint' => 'fk_services_subsidiary'])
              ->create();
    }
}
