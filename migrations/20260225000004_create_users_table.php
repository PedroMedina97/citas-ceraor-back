<?php

use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('users', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('parent_id', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('name', 'string', ['limit' => 50])
              ->addColumn('lastname', 'string', ['limit' => 100])
              ->addColumn('email', 'string', ['limit' => 100, 'null' => true])
              ->addColumn('password', 'string', ['limit' => 255])
              ->addColumn('birthday', 'date')
              ->addColumn('phone', 'string', ['limit' => 20, 'null' => true])
              ->addColumn('related', 'string', ['limit' => 100, 'null' => true])
              ->addColumn('address', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('id_rol', 'integer', ['null' => true])
              ->addColumn('image', 'text', ['null' => true, 'limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG])
              ->addColumn('professional_id', 'string', ['limit' => 50, 'null' => true])
              ->addColumn('first_login', 'integer', ['limit' => \Phinx\Db\Adapter\MysqlAdapter::INT_TINY, 'null' => true])
              ->addColumn('active', 'integer', ['null' => true])
              ->addColumn('created_at', 'date')
              ->addColumn('updated_at', 'date')
              ->addForeignKey('id_rol', 'rols', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION', 'constraint' => 'fk_rols_users'])
              ->create();
    }
}
