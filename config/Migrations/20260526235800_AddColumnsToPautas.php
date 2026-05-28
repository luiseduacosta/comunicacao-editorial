<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddColumnsToPautasNovo extends BaseMigration
{
    public function change(): void
    {
        $this->table('pautas')
            ->addColumn('titulo', 'string', ['limit' => 256, 'null' => false])
            ->addColumn('anexos', 'string', ['limit' => 500, 'null' => true])
            ->addColumn('observacoes', 'string', ['limit' => 255, 'null' => true])
            ->save();
    }
}
 