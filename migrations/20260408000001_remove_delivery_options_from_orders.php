<?php

use Phinx\Migration\AbstractMigration;

class RemoveDeliveryOptionsFromOrders extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('orders');
        
        // Eliminar las columnas de opciones de entrega
        $columnsToRemove = [
            'acetate_print',
            'paper_print',
            'send_email',
            'packet'
        ];
        
        foreach ($columnsToRemove as $column) {
            if ($table->hasColumn($column)) {
                $table->removeColumn($column);
            }
        }
        
        $table->update();
    }
}
