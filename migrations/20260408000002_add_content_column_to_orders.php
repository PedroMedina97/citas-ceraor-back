<?php

use Phinx\Migration\AbstractMigration;

class AddContentColumnToOrders extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('orders');
        
        // Agregar columna content antes de active
        $table->addColumn('content', 'text', [
            'limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG,
            'null' => true,
            'after' => 'method'
        ])
        ->update();
    }
}
