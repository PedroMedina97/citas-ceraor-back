<?php

use Phinx\Migration\AbstractMigration;

class SeedUsersTable extends AbstractMigration
{
    public function up()
    {
        // Usuario principal
        $this->execute("INSERT INTO `users` (`id`, `parent_id`, `name`, `lastname`, `email`, `password`, `birthday`, `phone`, `related`, `address`, `id_rol`, `image`, `professional_id`, `first_login`, `active`, `created_at`, `updated_at`) VALUES
        ('7f468cca-96c6-4547-ab90-9ba2c97dedc5', '', 'Pedro', 'Medina Robles', 'pedro.medina.ro97@outlook.com', '\$2y\$04\$zcW91vm4bJZ2ZE4xqV5NZ.C2qg5rWUbUedsT8.4xE/mafNg3FfjuC', '1997-04-24', '9371678906', '', 'Col. Tascoob Rio Mezcalapa Manz.3 Lote 8', 1, NULL, '-', NULL, 1, '2025-05-13', '2025-09-18')");
        
        // Usuario 4ece5663 referenciado en subsidiaries
        $this->execute("INSERT INTO `users` (`id`, `parent_id`, `name`, `lastname`, `email`, `password`, `birthday`, `phone`, `related`, `address`, `id_rol`, `image`, `professional_id`, `first_login`, `active`, `created_at`, `updated_at`) VALUES
        ('4ece5663-b099-4e6b-9d95-31806da4bdc4', '', 'Usuario', 'Sistema', 'sistema@ceraor3d.com', '\$2y\$04\$zcW91vm4bJZ2ZE4xqV5NZ.C2qg5rWUbUedsT8.4xE/mafNg3FfjuC', '1990-01-01', '0000000000', '', 'Sistema', 2, NULL, '-', NULL, 1, '2025-05-13', '2025-09-18')");
    }

    public function down()
    {
        $this->execute('DELETE FROM users');
    }
}
