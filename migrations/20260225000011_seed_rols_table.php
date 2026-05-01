<?php

use Phinx\Migration\AbstractMigration;

class SeedRolsTable extends AbstractMigration
{
    public function up()
    {
        $data = [
            ['id' => 1, 'name' => 'Owner', 'description' => 'Propietario del software', 'active' => 1, 'created_at' => '2025-01-27', 'updated_at' => '2025-01-27'],
            ['id' => 2, 'name' => 'Superadmin', 'description' => 'Administrador del sistema general', 'active' => 1, 'created_at' => '2025-01-27', 'updated_at' => '2025-01-27'],
            ['id' => 3, 'name' => 'Admin', 'description' => 'Administrador a nivel sucursal', 'active' => 1, 'created_at' => '2025-02-17', 'updated_at' => '2025-02-17'],
            ['id' => 4, 'name' => 'Recepcionista', 'description' => 'Gestionador de Citas', 'active' => 1, 'created_at' => '2025-01-27', 'updated_at' => '2025-01-27'],
            ['id' => 5, 'name' => 'Doctor', 'description' => 'Usuario afiliado para ordenes', 'active' => 1, 'created_at' => '2025-03-10', 'updated_at' => '2025-05-31'],
            ['id' => 6, 'name' => 'Paciente', 'description' => 'Consumidor de servicios', 'active' => 1, 'created_at' => '2025-01-27', 'updated_at' => '2025-06-06'],
            ['id' => 7, 'name' => 'Operativo', 'description' => 'Usuario operativo de CERAOR3D', 'active' => 1, 'created_at' => '2025-08-26', 'updated_at' => '2025-08-26'],
        ];

        $this->table('rols')->insert($data)->saveData();
    }

    public function down()
    {
        $this->execute('DELETE FROM rols');
    }
}
