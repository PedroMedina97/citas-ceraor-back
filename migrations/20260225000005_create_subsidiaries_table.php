<?php

use Phinx\Migration\AbstractMigration;

class CreateSubsidiariesTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('subsidiaries', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('id_user', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('name', 'string', ['limit' => 50])
              ->addColumn('address', 'string', ['limit' => 255])
              ->addColumn('active', 'integer', ['null' => true])
              ->addColumn('created_at', 'date')
              ->addColumn('updated_at', 'date')
              ->addForeignKey('id_user', 'users', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION', 'constraint' => 'fk_user_subsidiaries'])
              ->create();
    }
}
