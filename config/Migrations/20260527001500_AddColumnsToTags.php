<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddColumnsToTags extends BaseMigration
{
    public function change(): void
    {
        $this->table('tags')
            ->addColumn('observacoes', 'string', ['limit' => 255, 'null' => true])
            ->save();
    }
}
 