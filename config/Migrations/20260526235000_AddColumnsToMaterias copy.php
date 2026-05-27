<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddColumnsToMaterias extends BaseMigration
{
    public function change(): void
    {
        $this->table('materias')
            ->removeColumn('data')
            ->addColumn('publicar', 'tinyint', ['limit' => 1, 'default' => 0, 'null' => false])
            ->save();
    }
}