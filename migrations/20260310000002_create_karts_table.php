<?php

use Phinx\Migration\AbstractMigration;

class CreateKartsTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('karts', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('id_service', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('id_packet', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('total', 'float', ['precision' => 10, 'scale' => 2])
              ->addColumn('active', 'integer', ['null' => true, 'default' => 1])
              ->addColumn('created_at', 'datetime', ['null' => true])
              ->addColumn('updated_at', 'datetime', ['null' => true])
              ->addForeignKey('id_service', 'services', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION', 'constraint' => 'fk_karts_service'])
              ->addForeignKey('id_packet', 'packets', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION', 'constraint' => 'fk_karts_packet'])
              ->create();
    }
}
