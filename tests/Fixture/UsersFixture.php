<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'username' => 'admin',
                'password' => '$2y$12$eo.ChxRRR7d61xRglFv96uQwtFcPh0cPvRj4xq1cAowQCo2wVGjMS',
                'role' => 'admin',
                'created' => '2026-05-27 01:26:21',
                'modified' => '2026-05-27 01:26:21',
            ],
            [
                'id' => 2,
                'username' => 'user',
                'password' => '$2y$12$eo.ChxRRR7d61xRglFv96uQwtFcPh0cPvRj4xq1cAowQCo2wVGjMS',
                'role' => 'user',
                'created' => '2026-05-27 01:26:21',
                'modified' => '2026-05-27 01:26:21',
            ],
        ];
        parent::init();
    }
}
