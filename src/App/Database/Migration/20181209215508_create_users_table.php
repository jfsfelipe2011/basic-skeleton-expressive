<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration
{
    /**
     * Método que cria a tabela de usuários
     */
    public function up(): void
    {
        $this->table('users')
            ->addColumn('name', 'string')
            ->addColumn('email', 'string')
            ->addColumn('password', 'string')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->addIndex(['email'], ['unique' => true])
            ->save();
    }


    /**
     * Método que deleta tabela de usuários
     */
    public function down(): void
    {
        $this->table('users')->drop()->save();
    }
}
