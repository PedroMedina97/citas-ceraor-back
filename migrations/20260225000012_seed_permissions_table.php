<?php

use Phinx\Migration\AbstractMigration;

class SeedPermissionsTable extends AbstractMigration
{
    public function up()
    {
        $data = [
            ['id' => 1, 'name' => 'get_user', 'description' => 'Obtener usuarios incluyéndose', 'active' => 1, 'created_at' => '2025-01-27', 'updated_at' => '2025-01-27'],
            ['id' => 2, 'name' => 'getall_user', 'description' => 'Obtener todos mis usuarios relacionados', 'active' => 1, 'created_at' => '2025-01-27', 'updated_at' => '2025-01-27'],
            ['id' => 3, 'name' => 'create_user', 'description' => 'Crear usuarios', 'active' => 1, 'created_at' => '2025-02-17', 'updated_at' => '2025-02-17'],
            ['id' => 4, 'name' => 'update_user', 'description' => 'Actualizar o modificar usuarios', 'active' => 1, 'created_at' => '2025-01-27', 'updated_at' => '2025-01-27'],
            ['id' => 5, 'name' => 'delete_user', 'description' => 'Eliminar o desactivar usuarios', 'active' => 1, 'created_at' => '2025-01-27', 'updated_at' => '2025-01-27'],
            ['id' => 6, 'name' => 'get_subsidiary', 'description' => 'Obtener sucursal', 'active' => 1, 'created_at' => '2025-02-12', 'updated_at' => '2025-02-12'],
            ['id' => 7, 'name' => 'getall_subsidiary', 'description' => 'Obtener todas las sucursales', 'active' => 1, 'created_at' => '2025-02-12', 'updated_at' => '2025-02-12'],
            ['id' => 8, 'name' => 'create_subsidiary', 'description' => 'Crear sucursales', 'active' => 1, 'created_at' => '2025-02-12', 'updated_at' => '2025-02-12'],
            ['id' => 9, 'name' => 'update_subsidiary', 'description' => 'Actualizar sucursales', 'active' => 1, 'created_at' => '2025-02-12', 'updated_at' => '2025-02-12'],
            ['id' => 10, 'name' => 'delete_subsidiary', 'description' => 'Eliminar sucursales', 'active' => 1, 'created_at' => '2025-02-12', 'updated_at' => '2025-02-12'],
            ['id' => 11, 'name' => 'get_service', 'description' => 'Obtener servicio', 'active' => 1, 'created_at' => '2025-02-12', 'updated_at' => '2025-02-12'],
            ['id' => 12, 'name' => 'getall_service', 'description' => 'Obtener todos los servicios', 'active' => 1, 'created_at' => '2025-02-12', 'updated_at' => '2025-02-12'],
            ['id' => 13, 'name' => 'create_service', 'description' => 'Crear servicios', 'active' => 1, 'created_at' => '2025-02-12', 'updated_at' => '2025-02-12'],
            ['id' => 14, 'name' => 'update_service', 'description' => 'Actualizar servicios', 'active' => 1, 'created_at' => '2025-02-12', 'updated_at' => '2025-02-12'],
            ['id' => 15, 'name' => 'delete_service', 'description' => 'Eliminar Servicios', 'active' => 1, 'created_at' => '2025-02-12', 'updated_at' => '2025-02-12'],
            ['id' => 16, 'name' => 'get_appointment', 'description' => 'Obtener una cita', 'active' => 1, 'created_at' => '2025-02-26', 'updated_at' => '2025-02-26'],
            ['id' => 17, 'name' => 'getall_appointment', 'description' => 'obtener todas las citas de todas las sucursales', 'active' => 1, 'created_at' => '2025-02-26', 'updated_at' => '2025-02-26'],
            ['id' => 18, 'name' => 'create_appointment', 'description' => 'Crear cita', 'active' => 1, 'created_at' => '2025-02-26', 'updated_at' => '2025-02-26'],
            ['id' => 19, 'name' => 'update_appointment', 'description' => 'Re-agendar o actualizar una cita', 'active' => 1, 'created_at' => '2025-02-26', 'updated_at' => '2025-02-26'],
            ['id' => 20, 'name' => 'delete_appointment', 'description' => 'Cancelar una cita', 'active' => 1, 'created_at' => '2025-02-26', 'updated_at' => '2025-02-26'],
            ['id' => 21, 'name' => 'get_order', 'description' => 'Obtener orden', 'active' => 1, 'created_at' => '2025-02-27', 'updated_at' => '2025-02-27'],
            ['id' => 22, 'name' => 'getall_order', 'description' => 'Obtener todas las ordenes', 'active' => 1, 'created_at' => '2025-02-27', 'updated_at' => '2025-02-27'],
            ['id' => 23, 'name' => 'create_order', 'description' => 'Crear ordenes', 'active' => 1, 'created_at' => '2025-02-27', 'updated_at' => '2025-02-27'],
            ['id' => 24, 'name' => 'update_order', 'description' => 'Actualizar ordenes', 'active' => 1, 'created_at' => '2025-02-27', 'updated_at' => '2025-02-27'],
            ['id' => 25, 'name' => 'delete_order', 'description' => 'Eliminar ordenes', 'active' => 1, 'created_at' => '2025-02-27', 'updated_at' => '2025-02-27'],
            ['id' => 26, 'name' => 'get_rolpermission', 'description' => 'obtener permiso o rol', 'active' => 1, 'created_at' => '2025-02-28', 'updated_at' => '2025-02-28'],
            ['id' => 27, 'name' => 'getall_rolpermission', 'description' => 'Obtener todos los roles y permisos', 'active' => 1, 'created_at' => '2025-02-28', 'updated_at' => '2025-02-28'],
            ['id' => 28, 'name' => 'create_rolpermission', 'description' => 'Crear un nuevo rol o permiso', 'active' => 1, 'created_at' => '2025-02-28', 'updated_at' => '2025-02-28'],
            ['id' => 29, 'name' => 'update_rolpermission', 'description' => 'Actualizar un rol o permiso', 'active' => 1, 'created_at' => '2025-02-28', 'updated_at' => '2025-02-28'],
            ['id' => 30, 'name' => 'delete_rolpermission', 'description' => 'Eliminar rol o permiso', 'active' => 1, 'created_at' => '2025-02-28', 'updated_at' => '2025-02-28'],
            ['id' => 31, 'name' => 'get_client', 'description' => 'Obtener un cliente específico', 'active' => 1, 'created_at' => '2025-03-31', 'updated_at' => '2025-03-31'],
            ['id' => 32, 'name' => 'getall_client', 'description' => 'Ver todo el listado de clientes', 'active' => 1, 'created_at' => '2025-03-31', 'updated_at' => '2025-03-31'],
            ['id' => 33, 'name' => 'create_client', 'description' => 'Crear un cliente', 'active' => 1, 'created_at' => '2025-03-31', 'updated_at' => '2025-03-31'],
            ['id' => 34, 'name' => 'update_client', 'description' => 'Actualizar un cliente', 'active' => 1, 'created_at' => '2025-03-31', 'updated_at' => '2025-03-31'],
            ['id' => 35, 'name' => 'delete_client', 'description' => 'Eliminar un cliente', 'active' => 1, 'created_at' => '2025-03-31', 'updated_at' => '2025-03-31'],
            ['id' => 36, 'name' => 'see_client', 'description' => 'Ver vista de clientes', 'active' => 1, 'created_at' => '2025-03-31', 'updated_at' => '2025-03-31'],
            ['id' => 37, 'name' => 'see_user', 'description' => 'Ver o acceder al listado de usuario', 'active' => 1, 'created_at' => '2025-01-27', 'updated_at' => '2025-01-27'],
            ['id' => 38, 'name' => 'see_subsidiary', 'description' => 'Ver o acceder a al listado de sucursales', 'active' => 1, 'created_at' => '2025-01-27', 'updated_at' => '2025-01-27'],
            ['id' => 39, 'name' => 'see_service', 'description' => 'Ver o acceder al listado de servicios por sucursal', 'active' => 1, 'created_at' => '2025-01-27', 'updated_at' => '2025-01-27'],
            ['id' => 40, 'name' => 'see_appointment', 'description' => 'Ver o acceder al listado de citas', 'active' => 1, 'created_at' => '2025-01-27', 'updated_at' => '2025-01-27'],
            ['id' => 41, 'name' => 'see_order', 'description' => 'Ver o acceder al listado de ordenes', 'active' => 1, 'created_at' => '2025-01-27', 'updated_at' => '2025-01-27'],
            ['id' => 42, 'name' => 'see_rolpermission', 'description' => 'Ver o acceder al listado de roles y permisos', 'active' => 1, 'created_at' => '2025-01-27', 'updated_at' => '2025-01-27'],
            ['id' => 43, 'name' => 'see_rol', 'description' => 'Ver o acceder al listado de roles', 'active' => 1, 'created_at' => '2025-01-27', 'updated_at' => '2025-01-27'],
            ['id' => 44, 'name' => 'see_permission', 'description' => 'Ver o acceder al listado de permisos', 'active' => 1, 'created_at' => '2025-01-27', 'updated_at' => '2025-01-27'],
            ['id' => 45, 'name' => 'create_cashcut', 'description' => 'Crear corte de caja', 'active' => 1, 'created_at' => '2025-07-05', 'updated_at' => '2025-07-05'],
            ['id' => 46, 'name' => 'getall_cashcut', 'description' => 'Ver todos los cortes de caja', 'active' => 1, 'created_at' => '2025-07-05', 'updated_at' => '2025-07-05'],
            ['id' => 47, 'name' => 'get_cashcut', 'description' => 'Ver un corte en especifico', 'active' => 1, 'created_at' => '2025-07-05', 'updated_at' => '2025-07-05'],
            ['id' => 48, 'name' => 'update_cashcut', 'description' => 'Actualizar corte de caja', 'active' => 1, 'created_at' => '2025-07-05', 'updated_at' => '2025-07-05'],
            ['id' => 49, 'name' => 'delete_cashcut', 'description' => 'Eliminar un corte de caja', 'active' => 1, 'created_at' => '2025-07-05', 'updated_at' => '2025-07-05'],
            ['id' => 50, 'name' => 'see_cashcut', 'description' => 'Ver módulo de cortes de caja', 'active' => 1, 'created_at' => '2025-07-05', 'updated_at' => '2025-07-05'],
            ['id' => 51, 'name' => 'see_payment', 'description' => 'Ver listado de pagos', 'active' => 1, 'created_at' => '2025-09-13', 'updated_at' => '2025-09-13'],
            ['id' => 52, 'name' => 'see_admingraphic', 'description' => 'Ver gráficas del administrador', 'active' => 1, 'created_at' => '2025-09-24', 'updated_at' => '2025-09-24'],
        ];

        $this->table('permissions')->insert($data)->saveData();
    }

    public function down()
    {
        $this->execute('DELETE FROM permissions');
    }
}
