<?php

use Phinx\Migration\AbstractMigration;

class SeedServicesTable extends AbstractMigration
{
    public function up()
    {
        $sql = "INSERT INTO `services` (`id`, `name`, `id_subsidiary`, `description`, `price`, `active`, `created_at`, `updated_at`) VALUES
        ('08d88242-2cb9-4692-93e5-026d8d5fd4b0', 'Básico Digital', '30f3e0d9-71f8-428f-b618-9d448cc9c7ba', 'Servicio Básico Digital', 650, 1, '2025-07-14', '2025-07-14'),
        ('095bd788-603e-46bb-a3bb-5a4daa30f00b', 'Básico', '30f3e0d9-71f8-428f-b618-9d448cc9c7ba', 'Servicio Básico', 1180, 1, '2025-07-14', '2025-07-14'),
        ('097f421e-696d-4bc4-b71c-44d169f14cfc', 'Series Intraorales', '023b21b8-3245-42b1-9ced-fa2cc9b651d5', '-', 0, 1, '2025-09-24', '2025-09-24'),
        ('138831a6-face-4fba-b18d-9074b5615771', 'Personalizado', '023b21b8-3245-42b1-9ced-fa2cc9b651d5', 'Precios variados', 0, 1, '2025-07-14', '2025-07-14'),
        ('16ae7e0c-3a5e-4323-a5e3-64a091b825a4', 'Básico', '023b21b8-3245-42b1-9ced-fa2cc9b651d5', 'Servicio básico CERAOR3D', 1180, 1, '2025-07-14', '2025-07-14'),
        ('1758d21a-014a-4fe7-8e14-789e1ae1dcb2', 'Escaneo Intraoral', '587040b5-8d10-42ba-94a2-098289726243', '-', 600, 1, '2025-09-24', '2025-09-24'),
        ('1b53df0c-ed5f-4ed8-a62c-f17be898787e', 'Basico', '587040b5-8d10-42ba-94a2-098289726243', '-', 1180, 1, '2025-09-24', '2025-09-24'),
        ('34623a5e-6e27-440d-9569-ebf5bee37ecc', 'Fotografía Int. y Ext', '023b21b8-3245-42b1-9ced-fa2cc9b651d5', '-', 260, 1, '2025-09-24', '2025-09-24'),
        ('426a7130-35e4-4f16-a155-71ac3e18df76', 'Modelo de Estudio', 'b4a9d2a3-d063-4fad-aac1-73e718a29b5a', '-', 0, 1, '2025-09-24', '2025-09-24'),
        ('470fdbce-547d-4cc8-ad19-4433a1717a67', 'Personalizado', 'b4a9d2a3-d063-4fad-aac1-73e718a29b5a', 'Precios Variados', 0, 1, '2025-07-14', '2025-07-14'),
        ('4bd27b29-10f0-442a-ac16-cf6a8deef913', 'Series Intraorales', '587040b5-8d10-42ba-94a2-098289726243', '-', 0, 1, '2025-09-24', '2025-09-24'),
        ('4c921b3e-d32e-4b2f-ab88-1855ff2adfd0', 'Series Intraorales', '30f3e0d9-71f8-428f-b618-9d448cc9c7ba', '-', 0, 1, '2025-09-24', '2025-09-24'),
        ('4faa39f0-7020-4ecf-9a8d-13b36316b276', '3D(Con tomografía)', '4f7a148c-efda-452a-b15a-0568d10d2920', 'Servicio 3D', 2150, 1, '2025-07-05', '2025-07-05'),
        ('548c0d70-1ab6-414d-9b98-f1f52f872127', '3D(Con Tomografía)', '30f3e0d9-71f8-428f-b618-9d448cc9c7ba', '3D', 2150, 1, '2025-07-14', '2025-07-14'),
        ('553fde75-0266-404e-b2ca-fe531eba9b79', 'Fotografía Int. y Ext', '4f7a148c-efda-452a-b15a-0568d10d2920', '-', 260, 1, '2025-09-24', '2025-09-24'),
        ('55f81224-2657-4832-80de-d820ad7a2ff4', 'Básico', 'b4a9d2a3-d063-4fad-aac1-73e718a29b5a', 'Servicio Básico', 1180, 1, '2025-07-14', '2025-07-14'),
        ('6513ebe3-bbac-43f4-943b-2c3d7e41dfbe', 'Escaneo Intraoral', 'b4a9d2a3-d063-4fad-aac1-73e718a29b5a', '-', 600, 1, '2025-09-24', '2025-09-24'),
        ('77836a44-cf31-40ef-b0fe-6be3d76b9f55', '3D (con Tomografía)', '587040b5-8d10-42ba-94a2-098289726243', '-', 2150, 1, '2025-09-24', '2025-09-24'),
        ('818a010d-c0ef-4d53-8db1-176e4415f538', 'Series Intraorales', 'b4a9d2a3-d063-4fad-aac1-73e718a29b5a', '-', 0, 1, '2025-09-24', '2025-09-24'),
        ('84ff697c-e96b-4c97-b04c-38ab1f49c236', 'Modelo de Estudio.', '023b21b8-3245-42b1-9ced-fa2cc9b651d5', '-', 0, 1, '2025-09-24', '2025-09-24'),
        ('8593615f-57bf-4388-9c45-ad8b1b960c05', 'Modelo de Estudio', '4f7a148c-efda-452a-b15a-0568d10d2920', '-', 0, 1, '2025-09-24', '2025-09-24'),
        ('887e61f1-8af2-4c1c-92a6-969ff26b5f22', 'Básico', '4f7a148c-efda-452a-b15a-0568d10d2920', 'Servicio básico', 1180, 1, '2025-07-05', '2025-07-05'),
        ('904c74f6-a81f-4a26-a48c-67e4b2d1a26e', 'Fotografía Int. y Ext.', '587040b5-8d10-42ba-94a2-098289726243', '-', 260, 1, '2025-09-24', '2025-09-24'),
        ('9fdbde99-1558-44c4-9941-cd7676691db7', 'Escaneo', '4f7a148c-efda-452a-b15a-0568d10d2920', '-', 600, 1, '2025-09-24', '2025-09-24'),
        ('a3dc0e91-05c1-420d-93ab-e6b2cc8657dc', '3D (Con Tomografía)', 'b4a9d2a3-d063-4fad-aac1-73e718a29b5a', '3D ', 2150, 1, '2025-07-14', '2025-07-14'),
        ('ab059fca-d96a-4235-a9bb-bc52cac65dd7', 'Fotografía Int. y Ext.', 'b4a9d2a3-d063-4fad-aac1-73e718a29b5a', '-', 260, 1, '2025-09-24', '2025-09-24'),
        ('ab6a41b4-b178-4d4b-a9c7-1cd0b10e17a0', 'Básico Digital', '587040b5-8d10-42ba-94a2-098289726243', '-', 650, 1, '2025-09-24', '2025-09-24'),
        ('c6a18b51-9b1e-47a4-9250-e788eb461a45', 'Básico Digital', '4f7a148c-efda-452a-b15a-0568d10d2920', '(Sin impresiones)', 650, 1, '2025-07-05', '2025-07-05'),
        ('caddc1fd-1e82-456e-a7d8-e9ece2fa76f5', 'Personalizado', '30f3e0d9-71f8-428f-b618-9d448cc9c7ba', 'Precios Variados', 0, 1, '2025-07-14', '2025-07-14'),
        ('d0715529-53c4-4a75-b875-59e49c6f5b80', 'Fotografía Int. y Ext.', '30f3e0d9-71f8-428f-b618-9d448cc9c7ba', '-', 260, 1, '2025-09-24', '2025-09-24'),
        ('d8e8f55b-efa4-4be6-b884-62cbfe3b2840', '3D (Con tomografía)', '023b21b8-3245-42b1-9ced-fa2cc9b651d5', 'Servicio 3D', 2150, 1, '2025-07-14', '2025-07-14'),
        ('dbd5182d-b946-4ae4-abbf-b142147997ad', 'Escaneo Intraoral', '30f3e0d9-71f8-428f-b618-9d448cc9c7ba', '-', 600, 1, '2025-09-24', '2025-09-24'),
        ('e41d46a6-ba8c-436b-bc8c-336f03d0ff75', 'Series Intraorales', '4f7a148c-efda-452a-b15a-0568d10d2920', '-', 0, 1, '2025-09-24', '2025-09-24'),
        ('e9ced796-03c9-4cba-87a9-c639c5279860', 'Modelos de Estudio', '587040b5-8d10-42ba-94a2-098289726243', '-', 0, 1, '2025-09-24', '2025-09-24'),
        ('ef8e457e-e62f-4900-a6cd-24fec04b0e85', 'Básico Digital', '023b21b8-3245-42b1-9ced-fa2cc9b651d5', 'Servicio  Básico Digital', 650, 1, '2025-07-14', '2025-07-14'),
        ('f8396b59-05bd-44cd-a7e2-81b978ed7657', 'Personalizado', '4f7a148c-efda-452a-b15a-0568d10d2920', 'Servicio mixto', 0, 1, '2025-07-05', '2025-07-05'),
        ('f91b456d-f381-4896-a004-4b003370646c', 'Escaneo Intraoral', '023b21b8-3245-42b1-9ced-fa2cc9b651d5', '-', 600, 1, '2025-09-24', '2025-09-24'),
        ('fa10d4ea-3aa2-4ba1-8e4a-526f9f665de8', 'Modelos de Estudio', '30f3e0d9-71f8-428f-b618-9d448cc9c7ba', '-', 0, 1, '2025-09-24', '2025-09-24'),
        ('fbabc54f-5d4e-4bcb-b0cf-f3eb398f9b92', 'Básico Digital', 'b4a9d2a3-d063-4fad-aac1-73e718a29b5a', 'Servicio Digital', 650, 1, '2025-07-14', '2025-07-14')";
        
        $this->execute($sql);
    }

    public function down()
    {
        $this->execute('DELETE FROM services');
    }
}
