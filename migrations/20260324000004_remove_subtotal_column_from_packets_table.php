<?php

use Phinx\Migration\AbstractMigration;

class RemoveSubtotalColumnFromPacketsTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('packets');
        $table->removeColumn('subtotal')
              ->update();
    }
}
