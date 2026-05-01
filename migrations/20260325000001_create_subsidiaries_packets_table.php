<?php

use Phinx\Migration\AbstractMigration;

class CreateSubsidiariesPacketsTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('subsidiaries_packets', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('id_subsidiary', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('id_packet', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('price', 'float', ['precision' => 10, 'scale' => 2])
              ->addColumn('active', 'integer', ['null' => true, 'default' => 1])
              ->addColumn('created_at', 'datetime', ['null' => true])
              ->addColumn('updated_at', 'datetime', ['null' => true])
              ->addForeignKey('id_subsidiary', 'subsidiaries', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION', 'constraint' => 'fk_subsidiaries_packets_subsidiary'])
              ->addForeignKey('id_packet', 'packets', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION', 'constraint' => 'fk_subsidiaries_packets_packet'])
              ->create();
    }
}
