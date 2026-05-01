<?php

use Phinx\Migration\AbstractMigration;

class CreatePacketsServicesTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('packets_services', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('id_packet', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('id_service', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('price', 'float', ['precision' => 10, 'scale' => 2])
              ->addColumn('active', 'integer', ['null' => true, 'default' => 1])
              ->addColumn('created_at', 'datetime', ['null' => true])
                ->addColumn('updated_at', 'datetime', ['null' => true])
              ->addForeignKey('id_packet', 'packets', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION', 'constraint' => 'fk_packets_services_packet'])
              ->addForeignKey('id_service', 'services', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION', 'constraint' => 'fk_packets_services_service'])
              ->create();
    }
}
