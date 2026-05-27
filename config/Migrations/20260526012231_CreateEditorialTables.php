<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateEditorialTables extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/5/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function change(): void
    {
        // Users Table
        if (!$this->hasTable('users')) {
            $this->table('users')
                ->addColumn('username', 'string', ['limit' => 50, 'null' => false])
                ->addColumn('password', 'string', ['limit' => 255, 'null' => false])
                ->addColumn('role', 'string', ['limit' => 20, 'default' => 'editor', 'null' => false])
                ->addColumn('created', 'datetime', ['default' => null, 'null' => true])
                ->addColumn('modified', 'datetime', ['default' => null, 'null' => true])
                ->addIndex(['username'], ['unique' => true])
                ->create();
        }

        // Pautas Table
        if (!$this->hasTable('pautas')) {
            $this->table('pautas')
                ->addColumn('data', 'date', ['null' => false])
                ->addColumn('titulo', 'string', ['limit' => 255, 'null' => false])
                ->addColumn('descricao', 'text', ['null' => true])
                ->addColumn('arquivar', 'boolean', ['default' => false, 'null' => false])
                ->addColumn('informandes', 'boolean', ['default' => false, 'null' => false])
                ->addColumn('observacoes', 'text', ['null' => true])
                ->addColumn('anexos', 'text', ['null' => true])
                ->addColumn('created', 'datetime', ['default' => null, 'null' => true])
                ->addColumn('modified', 'datetime', ['default' => null, 'null' => true])
                ->create();
        }

        // Materias Table
        if (!$this->hasTable('materias')) {
            $this->table('materias')
                ->addColumn('pauta_id', 'integer', ['null' => true])
                ->addColumn('titulo', 'string', ['limit' => 255, 'null' => false])
                ->addColumn('conteudo', 'text', ['null' => false])
                ->addColumn('arquivar', 'boolean', ['default' => false, 'null' => false])
                ->addColumn('publicar', 'boolean', ['default' => false, 'null' => false])
                ->addColumn('informandes', 'boolean', ['default' => false, 'null' => false])
                ->addColumn('anexos', 'text', ['null' => true])
                ->addColumn('created', 'datetime', ['default' => null, 'null' => true])
                ->addColumn('modified', 'datetime', ['default' => null, 'null' => true])
                ->addIndex(['pauta_id'])
                ->create();
        }

        // Tags Table
        if (!$this->hasTable('tags')) {
            $this->table('tags')
                ->addColumn('nome', 'string', ['limit' => 50, 'null' => false])
                ->addColumn('descricao', 'text', ['null' => true])
                ->addColumn('observacoes', 'text', ['null' => true])
                ->addColumn('created', 'datetime', ['default' => null, 'null' => true])
                ->addColumn('modified', 'datetime', ['default' => null, 'null' => true])
                ->addIndex(['nome'], ['unique' => true])
                ->create();
        }

        // MateriasTags Join Table
        if (!$this->hasTable('materias_tags')) {
            $this->table('materias_tags')
                ->addColumn('materia_id', 'integer', ['null' => false])
                ->addColumn('tag_id', 'integer', ['null' => false])
                ->addIndex(['materia_id', 'tag_id'], ['unique' => true])
                ->addIndex(['tag_id'])
                ->create();
        }

        // Comentapautas Table
        if (!$this->hasTable('comentapautas')) {
            $this->table('comentapautas')
                ->addColumn('pauta_id', 'integer', ['null' => false])
                ->addColumn('user_id', 'integer', ['null' => true])
                ->addColumn('autor', 'string', ['limit' => 50, 'null' => true])
                ->addColumn('comentario', 'text', ['null' => false])
                ->addColumn('created', 'datetime', ['default' => null, 'null' => true])
                ->addColumn('modified', 'datetime', ['default' => null, 'null' => true])
                ->addIndex(['pauta_id'])
                ->addIndex(['user_id'])
                ->create();
        }

        // Observacoes Table
        if (!$this->hasTable('observacoes')) {
            $this->table('observacoes')
                ->addColumn('materia_id', 'integer', ['null' => false])
                ->addColumn('user_id', 'integer', ['null' => true])
                ->addColumn('autor', 'string', ['limit' => 50, 'null' => true])
                ->addColumn('observacao', 'text', ['null' => false])
                ->addColumn('created', 'datetime', ['default' => null, 'null' => true])
                ->addColumn('modified', 'datetime', ['default' => null, 'null' => true])
                ->addIndex(['materia_id'])
                ->addIndex(['user_id'])
                ->create();
        }
    }
}
