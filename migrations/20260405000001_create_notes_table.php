<?php

use Phinx\Migration\AbstractMigration;

class CreateNotesTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('notes', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('id_order', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('id_service', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('description', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('active', 'integer', ['null' => true])
              ->addColumn('created_at', 'datetime')
              ->addColumn('updated_at', 'datetime')
              ->addForeignKey('id_order', 'orders', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION', 'constraint' => 'fk_orders_notes'])
              ->addForeignKey('id_service', 'services', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION', 'constraint' => 'fk_services_notes'])
              ->create();
    }
}
