<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddColumnsToComentapautas extends BaseMigration
{
    public function change(): void
    {
        $this->table('comentapautas')
            ->addColumn('autor', 'string', ['limit' => 50, 'null' => true])
            ->save();
    }
}