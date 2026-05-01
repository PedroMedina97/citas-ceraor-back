<?php

use Phinx\Migration\AbstractMigration;

class CreatePacketsTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('packets', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('id_service', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('subtotal', 'float', ['precision' => 10, 'scale' => 2])
              ->addColumn('active', 'integer', ['null' => true, 'default' => 1])
              ->addColumn('created_at', 'datetime', ['null' => true])
              ->addColumn('updated_at', 'datetime', ['null' => true])
              ->addForeignKey('id_service', 'services', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION', 'constraint' => 'fk_packets_service'])
              ->create();
    }
}
