<?php

use Phinx\Migration\AbstractMigration;

class CreatePaymentsTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('payments', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('id_appointment', 'string', ['limit' => 255])
              ->addColumn('method', 'string', ['limit' => 50])
              ->addColumn('amount', 'float')
              ->addColumn('status', 'string', ['limit' => 100, 'default' => '1'])
              ->addColumn('active', 'integer')
              ->addColumn('created_at', 'datetime')
              ->addColumn('updated_at', 'datetime', ['null' => true])
              ->addForeignKey('id_appointment', 'appointments', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
              ->create();
    }
}
