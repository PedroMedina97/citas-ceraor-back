<?php

use Phinx\Migration\AbstractMigration;

class SeedSubsidiariesTable extends AbstractMigration
{
    public function up()
    {
        $data = [
            ['id' => '023b21b8-3245-42b1-9ced-fa2cc9b651d5', 'id_user' => '4ece5663-b099-4e6b-9d95-31806da4bdc4', 'name' => 'Comalcalco', 'address' => 'CERAOR3D Comalcalco Santo Domingo, 86340 Comalcalco, Tab.', 'active' => 1, 'created_at' => '2025-05-31', 'updated_at' => '2025-07-04'],
            ['id' => '30f3e0d9-71f8-428f-b618-9d448cc9c7ba', 'id_user' => '4ece5663-b099-4e6b-9d95-31806da4bdc4', 'name' => 'Cárdenas', 'address' => 'Av. Lázaro Cárdenas No. 1000 Local 20, Plaza Aqua C.P. 86500 Cárdenas, Tabasco.', 'active' => 1, 'created_at' => '2025-05-29', 'updated_at' => '2025-07-04'],
            ['id' => '4f7a148c-efda-452a-b15a-0568d10d2920', 'id_user' => '4ece5663-b099-4e6b-9d95-31806da4bdc4', 'name' => 'Villahermosa', 'address' => 'BLVD. ADOLFO RUIZ CORTINES 804', 'active' => 1, 'created_at' => '2025-05-20', 'updated_at' => '2025-07-04'],
            ['id' => '587040b5-8d10-42ba-94a2-098289726243', 'id_user' => '7f468cca-96c6-4547-ab90-9ba2c97dedc5', 'name' => 'Veracruz, Ver.', 'address' => 'Calle España No.23, Fracc. Reforma, 91919, Veracruz, Ver.', 'active' => 1, 'created_at' => '2025-09-03', 'updated_at' => '2025-09-03'],
            ['id' => 'b4a9d2a3-d063-4fad-aac1-73e718a29b5a', 'id_user' => '7f468cca-96c6-4547-ab90-9ba2c97dedc5', 'name' => 'Tuxtla, Chiapas', 'address' => 'San Francisco El Sabinal 228-Planta Baja, San Francisco Sabinal, 29020 Tuxtla Gutiérrez, Chis.', 'active' => 1, 'created_at' => '2025-07-04', 'updated_at' => '2025-07-04'],
        ];

        $this->table('subsidiaries')->insert($data)->saveData();
    }

    public function down()
    {
        $this->execute('DELETE FROM subsidiaries');
    }
}
