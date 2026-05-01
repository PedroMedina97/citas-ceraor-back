<?php

use Phinx\Migration\AbstractMigration;

class AddNameColumnToPacketsTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('packets');
        $table->addColumn('name', 'string', ['limit' => 20, 'null' => true, 'after' => 'id'])
              ->update();
    }
}
