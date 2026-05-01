<?php

use Phinx\Migration\AbstractMigration;

class CreateRolsPermissionsTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('rols_permissions', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'integer', ['identity' => true])
              ->addColumn('id_permission', 'integer', ['null' => true])
              ->addColumn('id_rol', 'integer', ['null' => true])
              ->addColumn('active', 'integer', ['null' => true])
              ->addColumn('created_at', 'date')
              ->addColumn('updated_at', 'date')
              ->addForeignKey('id_permission', 'permissions', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION', 'constraint' => 'fk_permission'])
              ->addForeignKey('id_rol', 'rols', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION', 'constraint' => 'fk_rol'])
              ->create();
    }
}
