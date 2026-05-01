<?php

use Phinx\Migration\AbstractMigration;

class RemovePriceColumnFromPacketsServices extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('packets_services');
        $table->removeColumn('price')
              ->update();
    }
}
