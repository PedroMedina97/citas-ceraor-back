<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class SeedCatalogData extends AbstractMigration
{
    public function up(): void
    {
        $sql = <<<'SQL'
INSERT INTO `categories` (`id`, `name`, `inputs`, `active`, `created_at`, `updated_at`) VALUES
('0661abc5-6217-41ca-a795-b30eefa92bcb', 'Escaneo Facial', '', 1, '2026-05-05 21:07:48', '2026-05-05 21:07:48'),
('2c58c31d-eb3d-496d-8609-e5eb9811693d', 'Radiografías Intraorales', '', 1, '2026-05-05 20:29:27', '2026-05-05 20:29:27'),
('48021c61-167b-4969-9dcf-1e281ee60453', 'Escaneo Intraoral', '[{\"name\":\"Otros\",\"input\":\"text\",\"placeholder\":\"Ingrese Otros\",\"value\":\"\",\"characters\":\"30\",\"pattern\":\"^[a-zA-Z0-9 ]*$\"}]', 1, '2026-05-05 20:36:26', '2026-05-05 20:36:26'),
('51d729c1-ffff-48f1-ab7e-600a126f4211', 'Análisis Cefalométrico', '[{\"name\":\"Otros\",\"input\":\"text\",\"placeholder\":\"Ingrese Otros\",\"value\":\"\",\"characters\":\"30\",\"pattern\":\"^[a-zA-Z0-9 ]*$\"}]', 1, '2026-05-05 20:30:53', '2026-05-05 20:30:53'),
('73a2da56-46e6-43a6-821f-5616cbeb3fb5', 'Modelo de Estudio', '[{\"name\":\"Pieza\",\"input\":\"text\",\"placeholder\":\"Ingrese Pieza\",\"value\":\"\",\"characters\":\"30\",\"pattern\":\"^[a-zA-Z0-9 ]*$\"}]', 1, '2026-05-05 20:34:50', '2026-05-05 20:34:50'),
('7e76c0fc-0b3e-4f78-bd4a-e24029be8bec', 'Análisis de Modelo', '[{\"name\":\"Otros\",\"input\":\"text\",\"placeholder\":\"Ingrese Otros\",\"value\":\"\",\"characters\":\"30\",\"pattern\":\"^[a-zA-Z0-9 ]*$\"}]', 1, '2026-05-05 20:34:02', '2026-05-05 20:34:02'),
('8dec37a9-dcaa-4b4e-9f3a-46d7180e2281', 'Fotografía Clínica Intraoral y Extraoral', '', 1, '2026-05-05 20:30:08', '2026-05-05 20:30:08'),
('a1a113e9-9c6c-45ac-af1f-e822e8c43ee2', 'Tomografía 3D', '[{\"name\":\"ONDEMAND\",\"input\":\"checkbox\",\"value\":false},{\"name\":\"DICOM\",\"input\":\"checkbox\",\"value\":false},{\"name\":\"CARESTREAM\",\"input\":\"checkbox\",\"value\":false},{\"name\":\"MAC OS\",\"input\":\"checkbox\",\"value\":false},{\"name\":\"4X4 ENDODONCIA PIEZA NO.\",\"input\":\"text\",\"placeholder\":\"Ingrese 4X4 ENDODONCIA PIEZA NO. \",\"value\":\"\",\"characters\":\"30\",\"pattern\":\"^[a-zA-Z0-9 ]*$\"},{\"name\":\"5X5 ENDODONCIA PIEZA NO.\",\"input\":\"text\",\"placeholder\":\"Ingrese 5X5 ENDODONCIA PIEZA NO. \",\"value\":\"\",\"characters\":\"30\",\"pattern\":\"^[a-zA-Z0-9 ]*$\"},{\"name\":\"IMPLANTE NO.\",\"input\":\"text\",\"placeholder\":\"Ingrese IMPLANTE NO. \",\"value\":\"\",\"characters\":\"30\",\"pattern\":\"^[a-zA-Z0-9 ]*$\"},{\"name\":\"DIENTE RETENIDO:\",\"input\":\"text\",\"placeholder\":\"Ingrese DIENTE RETENIDO: \",\"value\":\"\",\"characters\":\"30\",\"pattern\":\"^[a-zA-Z0-9 ]*$\"},{\"name\":\"OTROS\",\"input\":\"text\",\"placeholder\":\"Ingrese OTROS\",\"value\":\"\",\"characters\":\"30\",\"pattern\":\"^[a-zA-Z0-9 ]*$\"},{\"name\":\"Est. Tomográfico\",\"input\":\"radiobutton\",\"value\":\"\",\"options\":[\"Con Informe\",\"Sin Informe\"]}]', 1, '2026-05-05 20:41:01', '2026-05-05 20:41:01'),
('b5c26e85-951f-49a4-8fc4-2b62130be93b', 'Estereolitografía', '[{\"name\":\"Otros\",\"input\":\"text\",\"placeholder\":\"Ingrese Otros\",\"value\":\"\",\"characters\":\"30\",\"pattern\":\"^[a-zA-Z0-9 ]*$\"}]', 1, '2026-05-05 20:37:53', '2026-05-05 20:37:53'),
('f406e2f5-1d1a-4c6b-ba1f-5011410de532', 'Radiografías', '[{\"name\":\"Impresión Acetato\",\"input\":\"checkbox\",\"value\":false},{\"name\":\"Impresión Papel Backlight Blanco\",\"input\":\"checkbox\",\"value\":false},{\"name\":\"E-mail\",\"input\":\"checkbox\",\"value\":false},{\"name\":\"Otros\",\"input\":\"text\",\"placeholder\":\"Ingrese Otros\",\"value\":\"\",\"characters\":\"30\",\"pattern\":\"^[a-zA-Z0-9 ]*$\"}]', 1, '2026-05-05 20:28:16', '2026-05-05 20:28:16');
SQL;
        $this->execute($sql);

        $sql = <<<'SQL'
INSERT INTO `packets` (`id`, `name`, `active`, `created_at`, `updated_at`) VALUES
('41033803-f31f-44a4-9ddb-733fa84e49c5', '3D (Con Tomografía)', 1, '2026-05-05 23:47:35', '2026-05-05 23:47:35'),
('d04f629a-20db-4d47-9f0e-c48171cde080', 'Básico Digital', 1, '2026-05-05 23:47:11', '2026-05-05 23:47:11'),
('f04f259b-da85-4504-a994-9c75affec32e', 'Básico', 1, '2026-05-05 23:47:01', '2026-05-05 23:47:01');
SQL;
        $this->execute($sql);

        $sql = <<<'SQL'
INSERT INTO `services` (`id`, `name`, `id_category`, `image`, `description`, `active`, `created_at`, `updated_at`) VALUES
('0053dc80-6741-4ce1-ad17-1f87199dad2a', 'A-P de Cráneo', 'f406e2f5-1d1a-4c6b-ba1f-5011410de532', '', '', 1, '2026-05-05', '2026-05-05'),
('0eeb65e2-a7e8-4442-805f-cc98d4695af7', 'Inferior', 'b5c26e85-951f-49a4-8fc4-2b62130be93b', '', '', 1, '2026-05-05', '2026-05-05'),
('12f79a1f-0ba3-4976-923a-d0c55be9e9da', 'Radiografía Ind. Periapical', '2c58c31d-eb3d-496d-8609-e5eb9811693d', '', '', 1, '2026-05-05', '2026-05-05'),
('14654db9-a755-4fee-b9f3-6593a1e25285', 'Guía Quirurgica', '73a2da56-46e6-43a6-821f-5616cbeb3fb5', '', '', 1, '2026-05-05', '2026-05-05'),
('18d5a69f-c52e-4fb9-bcdf-9d4fa88118ce', 'Tomografía ATM Boca Abierta y Cerrada ', 'a1a113e9-9c6c-45ac-af1f-e822e8c43ee2', '', '', 1, '2026-05-05', '2026-05-05'),
('28847b83-56e6-48a6-88fa-91b1e1da055d', 'Dentalprint 3D', '73a2da56-46e6-43a6-821f-5616cbeb3fb5', '', '', 1, '2026-05-05', '2026-05-05'),
('289031cb-91a0-4ac3-9041-5d64acae6d93', 'McNamara', '51d729c1-ffff-48f1-ab7e-600a126f4211', '', '', 1, '2026-05-05', '2026-05-05'),
('29322406-b5b3-460f-bac8-a973f4ef794f', 'OBJ', '48021c61-167b-4969-9dcf-1e281ee60453', '', '', 1, '2026-05-05', '2026-05-05'),
('2c5e4c88-da65-4ea4-8e7e-38d2c0b08804', 'PLY', '48021c61-167b-4969-9dcf-1e281ee60453', '', '', 1, '2026-05-05', '2026-05-05'),
('31517e8a-f577-4278-89dc-28a3c9137164', '(Cefalométrico a Elegir)', '51d729c1-ffff-48f1-ab7e-600a126f4211', '', '', 1, '2026-05-05', '2026-05-05'),
('3473d83e-ae46-4353-be7b-169e77b50175', 'INVISALIGN', '48021c61-167b-4969-9dcf-1e281ee60453', '', '', 1, '2026-05-05', '2026-05-05'),
('34bbd411-19e7-445b-b703-cb6390d62b3e', 'Rx Panorámica Arco Cuadrado (sin cóndillos)', 'f406e2f5-1d1a-4c6b-ba1f-5011410de532', '', '', 1, '2026-05-05', '2026-05-05'),
('364bcb9a-963e-459f-95c4-da7b3854184a', 'Jaraback', '51d729c1-ffff-48f1-ab7e-600a126f4211', '', '', 1, '2026-05-05', '2026-05-05'),
('367d7192-cdbe-4429-98cf-c6d3eb9b936c', 'Downs', '51d729c1-ffff-48f1-ab7e-600a126f4211', '', '', 1, '2026-05-05', '2026-05-05'),
('397515b3-ddb7-45b1-b914-de377b32396b', 'Dentalprint 4D (Incluye escaneo y tomografía)', '73a2da56-46e6-43a6-821f-5616cbeb3fb5', '', '', 1, '2026-05-05', '2026-05-05'),
('5537298d-f072-419d-aac9-813bd348310c', 'Escaneo Facial', '0661abc5-6217-41ca-a795-b30eefa92bcb', '', '', 1, '2026-05-05', '2026-05-05'),
('58651185-26ed-410b-a455-212761bd2707', 'Conductometría', '2c58c31d-eb3d-496d-8609-e5eb9811693d', '', '', 1, '2026-05-05', '2026-05-05'),
('6130c95d-964f-4b7f-9331-0fb1dcdc036d', 'Completa', 'b5c26e85-951f-49a4-8fc4-2b62130be93b', '', '', 1, '2026-05-05', '2026-05-05'),
('6458727e-5d08-4af7-b38d-adb0b86b3eb5', 'Tomografía Maxilar', 'a1a113e9-9c6c-45ac-af1f-e822e8c43ee2', '', '', 1, '2026-05-05', '2026-05-05'),
('666108dc-827c-4e53-9e21-fa12a4f23822', 'Análisis de Bolton Computarizado', '7e76c0fc-0b3e-4f78-bd4a-e24029be8bec', '', '', 1, '2026-05-05', '2026-05-05'),
('72ba9684-2381-4233-9335-0ca415ab6ddc', 'Rx Lateral de Cráneo con Tejidos Blandos', 'f406e2f5-1d1a-4c6b-ba1f-5011410de532', '', '', 1, '2026-05-05', '2026-05-05'),
('73473e42-3f36-463e-9653-71cd3d9c1b09', 'Análisis de Moyers', '7e76c0fc-0b3e-4f78-bd4a-e24029be8bec', '', '', 1, '2026-05-05', '2026-05-05'),
('7b12f2ac-0f0b-439f-94c3-605c2ef20d55', 'Dígito Palmar (Carpal)', 'f406e2f5-1d1a-4c6b-ba1f-5011410de532', '', '', 1, '2026-05-05', '2026-05-05'),
('7c11ef06-5546-4726-a239-19ec74f88fe7', 'Watters de Cráneo', 'f406e2f5-1d1a-4c6b-ba1f-5011410de532', '', '', 1, '2026-05-05', '2026-05-05'),
('7ce25a00-da56-4be8-b712-3638d29ece20', 'Superior', 'b5c26e85-951f-49a4-8fc4-2b62130be93b', '', '', 1, '2026-05-05', '2026-05-05'),
('89fe04a6-fd33-4043-be6a-4556b4960176', 'Steiner', '51d729c1-ffff-48f1-ab7e-600a126f4211', '', '', 1, '2026-05-05', '2026-05-05'),
('9c74b8ec-7ac9-41fc-89e3-c953ed7ff24e', 'Fotografía Clínica Intraoral y Extraoral', '8dec37a9-dcaa-4b4e-9f3a-46d7180e2281', '', '', 1, '2026-05-05', '2026-05-05'),
('9e8cfb66-ddf1-4046-8d59-b7f6e5d9bd78', 'Tomografía Oído', 'a1a113e9-9c6c-45ac-af1f-e822e8c43ee2', '', '', 1, '2026-05-05', '2026-05-05'),
('9f373e6a-1f25-44c0-be0b-d761fb7d8be1', 'Senos Paranasales (3 Proyecciones)', 'f406e2f5-1d1a-4c6b-ba1f-5011410de532', '', '', 1, '2026-05-05', '2026-05-05'),
('aa4b0651-f894-420c-9cd0-3e8fe9a50e3b', 'Tomografía SNP', 'a1a113e9-9c6c-45ac-af1f-e822e8c43ee2', '', '', 1, '2026-05-05', '2026-05-05'),
('acba9d3d-8012-4409-9968-eaf3e59f52c0', 'Tomografía Completa', 'a1a113e9-9c6c-45ac-af1f-e822e8c43ee2', '', '', 1, '2026-05-05', '2026-05-05'),
('aecad108-e557-4806-8c83-a57321752e8d', 'P-A de Cráneo', 'f406e2f5-1d1a-4c6b-ba1f-5011410de532', '', '', 1, '2026-05-05', '2026-05-05'),
('af8ab288-802c-4439-b078-edfe56c60e61', 'ATM Boca Abierta y Cerrada', 'f406e2f5-1d1a-4c6b-ba1f-5011410de532', '', '', 1, '2026-05-05', '2026-05-05'),
('b2890830-a6b0-4908-b9b8-496e5c95649f', 'Radiografía Oclusal', '2c58c31d-eb3d-496d-8609-e5eb9811693d', '', '', 1, '2026-05-05', '2026-05-05'),
('b2e7e93a-ad0c-4993-8dd9-357b74b07b8d', 'Intraoral Superior', '2c58c31d-eb3d-496d-8609-e5eb9811693d', '', '', 1, '2026-05-05', '2026-05-05'),
('b84c73ab-84b5-4819-aded-b2a990441779', 'Tomografía ATM Boca Cerrada', 'a1a113e9-9c6c-45ac-af1f-e822e8c43ee2', '', '', 1, '2026-05-05', '2026-05-05'),
('c066525b-819a-41bd-96e1-a1a8e6cc3e8d', 'Tomografía Ambos Maxilares', 'a1a113e9-9c6c-45ac-af1f-e822e8c43ee2', '', '', 1, '2026-05-05', '2026-05-05'),
('d748b2d4-39b9-4eaa-a2f0-012ae6a199b3', 'Intraoral Inferior', '2c58c31d-eb3d-496d-8609-e5eb9811693d', '', '', 1, '2026-05-05', '2026-05-05'),
('d7730163-2f8e-4edd-b014-965513ba902a', 'Tomografía Mandíbula', 'a1a113e9-9c6c-45ac-af1f-e822e8c43ee2', '', '', 1, '2026-05-05', '2026-05-05'),
('dbb0d890-ff8b-43d6-9e2e-2c7a96d7bfdb', 'Resina', '73a2da56-46e6-43a6-821f-5616cbeb3fb5', '', '', 1, '2026-05-05', '2026-05-05'),
('de6fb3b0-8d61-4701-89c9-2e72aa518710', 'STL', '48021c61-167b-4969-9dcf-1e281ee60453', '', '', 1, '2026-05-05', '2026-05-05'),
('e6ce1002-5b49-4f9b-a02a-1ed8e1938c02', 'Serie Periapical Completa', '2c58c31d-eb3d-496d-8609-e5eb9811693d', '', '', 1, '2026-05-05', '2026-05-05'),
('e8bf8f63-d9d4-4b9a-a2ec-1d24c58f28d2', 'Rickets', '51d729c1-ffff-48f1-ab7e-600a126f4211', '', '', 1, '2026-05-05', '2026-05-05'),
('f06433a4-d56c-4880-99d1-9e2161e92f85', 'Rx Panorámica', 'f406e2f5-1d1a-4c6b-ba1f-5011410de532', '', '', 1, '2026-05-05', '2026-05-05'),
('f93e6817-ba1a-41ef-9a54-347665f0984a', 'Perfilograma', 'f406e2f5-1d1a-4c6b-ba1f-5011410de532', '', '', 1, '2026-05-05', '2026-05-05'),
('fbf6a748-0e14-4ce6-bb8b-58bc2af509c2', 'Tomografía ATM Boca Abierta', 'a1a113e9-9c6c-45ac-af1f-e822e8c43ee2', '', '', 1, '2026-05-05', '2026-05-05');
SQL;
        $this->execute($sql);

        $sql = <<<'SQL'
INSERT INTO `packets_services` (`id`, `id_packet`, `id_service`, `active`, `created_at`, `updated_at`) VALUES
('05c6d54a-851f-47f9-8591-a57942aae95d', '41033803-f31f-44a4-9ddb-733fa84e49c5', '5537298d-f072-419d-aac9-813bd348310c', 1, NULL, NULL),
('083fe37b-56f9-477f-89d2-4d790ab4eac9', 'f04f259b-da85-4504-a994-9c75affec32e', 'f06433a4-d56c-4880-99d1-9e2161e92f85', 1, NULL, NULL),
('09b08c57-fc25-4ed1-8cab-957b675d4985', 'd04f629a-20db-4d47-9f0e-c48171cde080', 'f06433a4-d56c-4880-99d1-9e2161e92f85', 1, NULL, NULL),
('109572db-c538-45e0-933e-6518f69f1963', 'f04f259b-da85-4504-a994-9c75affec32e', '28847b83-56e6-48a6-88fa-91b1e1da055d', 1, NULL, NULL),
('29073034-7a8d-4882-b9c7-b84886042791', 'd04f629a-20db-4d47-9f0e-c48171cde080', '31517e8a-f577-4278-89dc-28a3c9137164', 1, NULL, NULL),
('31401d90-b060-4308-9280-bed4eb873ae8', '41033803-f31f-44a4-9ddb-733fa84e49c5', '397515b3-ddb7-45b1-b914-de377b32396b', 1, NULL, NULL),
('437cd605-cf22-40a6-ae18-9e5c2180334f', '41033803-f31f-44a4-9ddb-733fa84e49c5', '72ba9684-2381-4233-9335-0ca415ab6ddc', 1, NULL, NULL),
('94e9f698-4d00-4892-9f9a-67b5ad4959ad', '41033803-f31f-44a4-9ddb-733fa84e49c5', '9c74b8ec-7ac9-41fc-89e3-c953ed7ff24e', 1, NULL, NULL),
('9a7e3c1d-f9df-4ad6-a2bb-9267156c6ff5', 'f04f259b-da85-4504-a994-9c75affec32e', '72ba9684-2381-4233-9335-0ca415ab6ddc', 1, NULL, NULL),
('b068338c-4ab6-41f8-b8f9-f6dc585cf444', '41033803-f31f-44a4-9ddb-733fa84e49c5', 'f06433a4-d56c-4880-99d1-9e2161e92f85', 1, NULL, NULL),
('c2a3bd92-46fd-4ffa-8d21-f31debe223d2', 'f04f259b-da85-4504-a994-9c75affec32e', '9c74b8ec-7ac9-41fc-89e3-c953ed7ff24e', 1, NULL, NULL),
('c766b401-0b30-4154-8b41-d4d9e3206473', 'd04f629a-20db-4d47-9f0e-c48171cde080', '9c74b8ec-7ac9-41fc-89e3-c953ed7ff24e', 1, NULL, NULL),
('caa07641-2c24-45a1-b19f-e11eb403ecce', '41033803-f31f-44a4-9ddb-733fa84e49c5', 'de6fb3b0-8d61-4701-89c9-2e72aa518710', 1, NULL, NULL),
('d35dcb47-3200-4c81-9798-b4781ae6f333', 'd04f629a-20db-4d47-9f0e-c48171cde080', '72ba9684-2381-4233-9335-0ca415ab6ddc', 1, NULL, NULL),
('d82c1fc0-b9be-434a-85e1-c8c5af0d2a9a', '41033803-f31f-44a4-9ddb-733fa84e49c5', '31517e8a-f577-4278-89dc-28a3c9137164', 1, NULL, NULL),
('e2e22a60-fd8c-46d5-be54-2d135e2dfcad', '41033803-f31f-44a4-9ddb-733fa84e49c5', 'acba9d3d-8012-4409-9968-eaf3e59f52c0', 1, NULL, NULL);
SQL;
        $this->execute($sql);

        $sql = <<<'SQL'
INSERT INTO `subsidiaries_packets` (`id`, `id_subsidiary`, `id_packet`, `price`, `active`, `created_at`, `updated_at`) VALUES
('38ec5992-7da4-435f-b695-f81ee502bde6', '4f7a148c-efda-452a-b15a-0568d10d2920', 'f04f259b-da85-4504-a994-9c75affec32e', 1500.00, 1, NULL, NULL),
('39955aa5-be9a-4aa9-9036-6c9cfe392350', '4f7a148c-efda-452a-b15a-0568d10d2920', '41033803-f31f-44a4-9ddb-733fa84e49c5', 3000.00, 1, NULL, NULL),
('e0926793-4dfa-4d08-8cbc-b836d1106e2e', '4f7a148c-efda-452a-b15a-0568d10d2920', 'd04f629a-20db-4d47-9f0e-c48171cde080', 1000.00, 1, NULL, NULL);
SQL;
        $this->execute($sql);

        $sql = <<<'SQL'
INSERT INTO `subsidiaries_services` (`id`, `id_subsidiary`, `id_service`, `price`) VALUES
('042083a3-c0f9-4849-92d1-d2eba6ad04f7', '4f7a148c-efda-452a-b15a-0568d10d2920', '367d7192-cdbe-4429-98cf-c6d3eb9b936c', 250),
('043119f4-c3dd-4924-8ab6-890088e10673', '4f7a148c-efda-452a-b15a-0568d10d2920', '12f79a1f-0ba3-4976-923a-d0c55be9e9da', 320),
('044f9c83-f9a8-4b1b-a0c9-f27e178bc077', '4f7a148c-efda-452a-b15a-0568d10d2920', 'e8bf8f63-d9d4-4b9a-a2ec-1d24c58f28d2', 300),
('0fdb4d5e-0ada-45c7-ae86-3100660eb07f', '4f7a148c-efda-452a-b15a-0568d10d2920', '73473e42-3f36-463e-9653-71cd3d9c1b09', 500),
('1eaa0b59-6454-4b84-b9f9-62f0676b789e', '4f7a148c-efda-452a-b15a-0568d10d2920', '34bbd411-19e7-445b-b703-cb6390d62b3e', 600),
('21cd2823-3659-49cc-89f8-031176ac6d54', '4f7a148c-efda-452a-b15a-0568d10d2920', '14654db9-a755-4fee-b9f3-6593a1e25285', 300),
('25655655-df28-4be1-b6be-8ddc56a86309', '4f7a148c-efda-452a-b15a-0568d10d2920', '0053dc80-6741-4ce1-ad17-1f87199dad2a', 800),
('2d6d688f-76ca-45c5-8885-06de9b341733', '4f7a148c-efda-452a-b15a-0568d10d2920', '31517e8a-f577-4278-89dc-28a3c9137164', 300),
('2e5b35f6-4501-421b-841b-4ad0bba7e6c1', '4f7a148c-efda-452a-b15a-0568d10d2920', '397515b3-ddb7-45b1-b914-de377b32396b', 250),
('30217c7f-1d2e-4cff-8455-44949426c169', '4f7a148c-efda-452a-b15a-0568d10d2920', '7ce25a00-da56-4be8-b712-3638d29ece20', 400),
('325be43b-6167-4a9a-bdf7-de3310677798', '4f7a148c-efda-452a-b15a-0568d10d2920', 'b2e7e93a-ad0c-4993-8dd9-357b74b07b8d', 500),
('3ef4fab9-3826-4537-9f10-296fcd73a1a9', '4f7a148c-efda-452a-b15a-0568d10d2920', 'b84c73ab-84b5-4819-aded-b2a990441779', 500),
('42530ec6-14c1-4dcd-b3f3-5bb6f275c9c6', '4f7a148c-efda-452a-b15a-0568d10d2920', '58651185-26ed-410b-a455-212761bd2707', 250),
('4c62e1e7-192e-449d-9610-f84d2aa64f19', '4f7a148c-efda-452a-b15a-0568d10d2920', 'aecad108-e557-4806-8c83-a57321752e8d', 220),
('4e6a38bd-0715-4e3e-9e48-d31b6a60cb8f', '4f7a148c-efda-452a-b15a-0568d10d2920', '28847b83-56e6-48a6-88fa-91b1e1da055d', 250),
('53488abf-cc59-463e-bff0-94e4d3a34f1e', '4f7a148c-efda-452a-b15a-0568d10d2920', '29322406-b5b3-460f-bac8-a973f4ef794f', 500),
('6432d587-90bf-4489-8f64-1f8466722cbc', '4f7a148c-efda-452a-b15a-0568d10d2920', '6130c95d-964f-4b7f-9331-0fb1dcdc036d', 250),
('678dc15b-49c8-4c75-ae72-bce731605d21', '4f7a148c-efda-452a-b15a-0568d10d2920', '9f373e6a-1f25-44c0-be0b-d761fb7d8be1', 230),
('7450946b-2cae-47e0-ab2a-cbf96860e83b', '4f7a148c-efda-452a-b15a-0568d10d2920', 'b2890830-a6b0-4908-b9b8-496e5c95649f', 700),
('819ed3e1-401b-414d-9f68-142b07225442', '4f7a148c-efda-452a-b15a-0568d10d2920', 'f93e6817-ba1a-41ef-9a54-347665f0984a', 600),
('82a78447-31ee-45d5-889b-c3b9fe050905', '4f7a148c-efda-452a-b15a-0568d10d2920', '9c74b8ec-7ac9-41fc-89e3-c953ed7ff24e', 250),
('86b05bb9-cee3-4772-990e-08e17388d922', '4f7a148c-efda-452a-b15a-0568d10d2920', '89fe04a6-fd33-4043-be6a-4556b4960176', 1500),
('89e43021-0dbc-4106-a5f5-798c704b7812', '4f7a148c-efda-452a-b15a-0568d10d2920', 'aa4b0651-f894-420c-9cd0-3e8fe9a50e3b', 900),
('96597bd4-3fd2-4991-bef0-89758659e66f', '4f7a148c-efda-452a-b15a-0568d10d2920', '7c11ef06-5546-4726-a239-19ec74f88fe7', 700),
('a0f37aa5-b522-40ce-85f4-6f940c757e2a', '4f7a148c-efda-452a-b15a-0568d10d2920', '5537298d-f072-419d-aac9-813bd348310c', 500),
('a7822d9b-6e6e-43a0-b5aa-6deb9548ae8a', '4f7a148c-efda-452a-b15a-0568d10d2920', '72ba9684-2381-4233-9335-0ca415ab6ddc', 100),
('b36a97b0-e254-4948-9ddf-c0e5c67e056b', '4f7a148c-efda-452a-b15a-0568d10d2920', 'acba9d3d-8012-4409-9968-eaf3e59f52c0', 500),
('b558b00f-db42-4b70-bb21-ffa2617d3083', '4f7a148c-efda-452a-b15a-0568d10d2920', '3473d83e-ae46-4353-be7b-169e77b50175', 350),
('bcaa1d65-bcd9-4786-83fc-1b047b957673', '4f7a148c-efda-452a-b15a-0568d10d2920', '9e8cfb66-ddf1-4046-8d59-b7f6e5d9bd78', 350),
('bd0a8043-e8c8-4ca6-bd8e-dcba2bc82c9c', '4f7a148c-efda-452a-b15a-0568d10d2920', 'c066525b-819a-41bd-96e1-a1a8e6cc3e8d', 500),
('bd16a980-1d5a-4d2c-8ed4-8706ec814973', '4f7a148c-efda-452a-b15a-0568d10d2920', '666108dc-827c-4e53-9e21-fa12a4f23822', 300),
('c04c1ba8-732f-4585-889a-74e93701bf05', '4f7a148c-efda-452a-b15a-0568d10d2920', '289031cb-91a0-4ac3-9041-5d64acae6d93', 250),
('c7f6bfab-2965-460d-ab05-e272bdc07a4e', '4f7a148c-efda-452a-b15a-0568d10d2920', '6458727e-5d08-4af7-b38d-adb0b86b3eb5', 600),
('c8512fe5-b6b8-4150-ab31-486cc706cac6', '4f7a148c-efda-452a-b15a-0568d10d2920', 'f06433a4-d56c-4880-99d1-9e2161e92f85', 500),
('c8ea3b2f-3cac-49c4-a988-1631e71c0440', '4f7a148c-efda-452a-b15a-0568d10d2920', 'd7730163-2f8e-4edd-b014-965513ba902a', 500),
('c983b78f-f655-4e1e-9134-aab38087e86f', '4f7a148c-efda-452a-b15a-0568d10d2920', '7b12f2ac-0f0b-439f-94c3-605c2ef20d55', 250),
('c98dd71c-24c9-46cf-b44a-57258b593bf4', '4f7a148c-efda-452a-b15a-0568d10d2920', 'd748b2d4-39b9-4eaa-a2f0-012ae6a199b3', 300),
('cc0e63d1-60f4-4515-b9fa-c0f41f139baf', '4f7a148c-efda-452a-b15a-0568d10d2920', 'de6fb3b0-8d61-4701-89c9-2e72aa518710', 2000),
('da00c0ac-631c-4a0a-9f3d-62b86bae58a4', '4f7a148c-efda-452a-b15a-0568d10d2920', 'fbf6a748-0e14-4ce6-bb8b-58bc2af509c2', 500),
('dcc76854-46a9-46eb-b289-e1598b7b3c5e', '4f7a148c-efda-452a-b15a-0568d10d2920', 'af8ab288-802c-4439-b078-edfe56c60e61', 250),
('e20e2c5b-d0fa-4979-b85f-d759104ed237', '4f7a148c-efda-452a-b15a-0568d10d2920', 'e6ce1002-5b49-4f9b-a02a-1ed8e1938c02', 700),
('e243f9b7-9feb-4379-8b8a-e2af2c435263', '4f7a148c-efda-452a-b15a-0568d10d2920', '0eeb65e2-a7e8-4442-805f-cc98d4695af7', 150),
('e60715da-55ca-46d8-b79b-1ea0ac4b82da', '4f7a148c-efda-452a-b15a-0568d10d2920', 'dbb0d890-ff8b-43d6-9e2e-2c7a96d7bfdb', 260),
('e8062a2e-c462-4819-97ad-30a7cb4f4ed5', '4f7a148c-efda-452a-b15a-0568d10d2920', '2c5e4c88-da65-4ea4-8e7e-38d2c0b08804', 700),
('ef74e136-7f8d-43ec-97ae-181983819c94', '4f7a148c-efda-452a-b15a-0568d10d2920', '364bcb9a-963e-459f-95c4-da7b3854184a', 400),
('ff7e8f00-1604-4e3c-81af-65854686b49c', '4f7a148c-efda-452a-b15a-0568d10d2920', '18d5a69f-c52e-4fb9-bcdf-9d4fa88118ce', 500);
SQL;
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->execute("DELETE FROM `subsidiaries_services` WHERE `id_subsidiary` = '4f7a148c-efda-452a-b15a-0568d10d2920'");
        $this->execute("DELETE FROM `subsidiaries_packets` WHERE `id_subsidiary` = '4f7a148c-efda-452a-b15a-0568d10d2920'");
        $this->execute("DELETE FROM `packets_services`");
        $this->execute("DELETE FROM `services`");
        $this->execute("DELETE FROM `packets`");
        $this->execute("DELETE FROM `categories`");
    }
}
