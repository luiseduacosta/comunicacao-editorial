<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddColumnsToMaterias extends BaseMigration
{
    public function change(): void
    {
        $this->table('materias')
            ->removeColumn('data')
            ->addColumn('publicar', 'boolean', ['default' => false, 'null' => false])
            ->save();
    }
}
