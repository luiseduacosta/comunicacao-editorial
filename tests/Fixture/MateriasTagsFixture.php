<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MateriasTagsFixture
 */
class MateriasTagsFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'materias_tags';
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
                'materia_id' => 1,
                'tag_id' => 1,
            ],
        ];
        parent::init();
    }
}
