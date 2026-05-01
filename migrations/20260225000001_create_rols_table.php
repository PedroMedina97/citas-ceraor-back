<?php

use Phinx\Migration\AbstractMigration;

class CreateRolsTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('rols', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'integer', ['identity' => true])
              ->addColumn('name', 'string', ['limit' => 50, 'null' => true])
              ->addColumn('description', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('active', 'integer', ['null' => true])
              ->addColumn('created_at', 'date')
              ->addColumn('updated_at', 'date')
              ->create();
    }
}
