<?php

use Phinx\Migration\AbstractMigration;

class CreateAppointmentsTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('appointments', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('id_order', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('client', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('personal', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('id_subsidiary', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('service', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('appointment', 'datetime')
              ->addColumn('end_appointment', 'datetime', ['null' => true])
              ->addColumn('barcode', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('code', 'string', ['limit' => 50])
              ->addColumn('color', 'string', ['limit' => 7, 'null' => true])
              ->addColumn('active', 'integer', ['null' => true])
              ->addColumn('created_at', 'date')
              ->addColumn('updated_at', 'date')
              ->addForeignKey('id_order', 'orders', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION', 'constraint' => 'fk_orders_appointments'])
              ->addForeignKey('id_subsidiary', 'subsidiaries', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION', 'constraint' => 'fk_subsidiary'])
              ->create();
    }
}
