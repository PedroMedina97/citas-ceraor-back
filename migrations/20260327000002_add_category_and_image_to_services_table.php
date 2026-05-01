<?php

use Phinx\Migration\AbstractMigration;

class AddCategoryAndImageToServicesTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('services');
        $table->addColumn('id_category', 'string', ['limit' => 255, 'null' => true, 'after' => 'name'])
              ->addColumn('image', 'text', ['limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG, 'null' => true, 'after' => 'id_category'])
              ->addForeignKey('id_category', 'categories', 'id', ['delete' => 'SET_NULL', 'update' => 'NO_ACTION', 'constraint' => 'fk_services_category'])
              ->update();
    }
}
