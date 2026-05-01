<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RemoveIdKartFromOrders extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('orders');
        
        // Verificar si existe la foreign key y eliminarla primero
        if ($table->hasForeignKey('id_kart')) {
            $table->dropForeignKey('id_kart');
        }
        
        // Eliminar la columna id_kart
        if ($table->hasColumn('id_kart')) {
            $table->removeColumn('id_kart');
        }
        
        $table->update();
    }
}
