<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddColumnsToObservacoesNovo extends BaseMigration
{
    public function change(): void
    {
        $this->table('observacoes')
            ->addColumn('autor', 'string', ['limit' => 50, 'null' => true])
            ->save();
    }
}
 