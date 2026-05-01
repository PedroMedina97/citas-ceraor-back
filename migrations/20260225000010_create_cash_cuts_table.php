<?php

use Phinx\Migration\AbstractMigration;

class CreateCashCutsTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('cash_cuts', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'char', ['limit' => 36, 'null' => false])
              ->addColumn('id_user', 'char', ['limit' => 36, 'null' => true])
              ->addColumn('id_subsidiary', 'char', ['limit' => 36, 'null' => true])
              ->addColumn('start_date', 'datetime', ['null' => true])
              ->addColumn('end_date', 'datetime', ['null' => true])
              ->addColumn('total', 'decimal', ['precision' => 10, 'scale' => 2, 'null' => true])
              ->addColumn('active', 'integer')
              ->addColumn('created_at', 'date', ['null' => true])
              ->addColumn('updated_at', 'date')
              ->addForeignKey('id_user', 'users', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION', 'constraint' => 'fk_cash_cuts_users'])
              ->addForeignKey('id_subsidiary', 'subsidiaries', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION', 'constraint' => 'fk_cash_cuts_subsidiaries'])
              ->create();
    }
}
