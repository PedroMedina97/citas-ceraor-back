<?php

use Phinx\Migration\AbstractMigration;

class UpdateServicesTableRemoveSubsidiaryRelation extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('services');
        
        // Remover la foreign key primero
        $table->dropForeignKey('id_subsidiary');
        
        // Luego remover la columna
        $table->removeColumn('id_subsidiary')
              ->update();
    }
}
