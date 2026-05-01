<?php

use Phinx\Migration\AbstractMigration;

class RemoveServiceRelationFromPackets extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('packets');
        $table->dropForeignKey('id_service', 'fk_packets_service')
              ->removeColumn('id_service')
              ->update();
    }
}
