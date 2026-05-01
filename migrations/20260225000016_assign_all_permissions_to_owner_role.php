<?php

use Phinx\Migration\AbstractMigration;

class AssignAllPermissionsToOwnerRole extends AbstractMigration
{
    public function up()
    {
        // Asignar todos los permisos al rol Owner
        $sql = "
            INSERT INTO rols_permissions (id_rol, id_permission)
            SELECT 
                r.id,
                p.id
            FROM rols r
            CROSS JOIN permissions p
            WHERE r.name = 'Owner'
            AND NOT EXISTS (
                SELECT 1 
                FROM rols_permissions rp 
                WHERE rp.id_rol = r.id 
                AND rp.id_permission = p.id
            )
        ";
        
        $this->execute($sql);
    }

    public function down()
    {
        // Eliminar todos los permisos del rol Owner
        $sql = "
            DELETE rp FROM rols_permissions rp
            INNER JOIN rols r ON r.id = rp.id_rol
            WHERE r.name = 'Owner'
        ";
        
        $this->execute($sql);
    }
}
