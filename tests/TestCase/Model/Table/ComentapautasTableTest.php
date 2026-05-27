<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ComentapautasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ComentapautasTable Test Case
 */
class ComentapautasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ComentapautasTable
     */
    protected $Comentapautas;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Comentapautas',
        'app.Pautas',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Comentapautas') ? [] : ['className' => ComentapautasTable::class];
        $this->Comentapautas = $this->getTableLocator()->get('Comentapautas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Comentapautas);
        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $comment = $this->Comentapautas->newEntity([]);
        $this->assertNotEmpty($comment->getErrors()['comentario']);

        $commentValid = $this->Comentapautas->newEntity([
            'pauta_id' => 1,
            'user_id' => 1,
            'comentario' => 'Novo Comentário',
        ]);
        $this->assertEmpty($commentValid->getErrors());
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        // pauta_id 999 does not exist
        $comment = $this->Comentapautas->newEntity([
            'pauta_id' => 999,
            'user_id' => 1,
            'comentario' => 'Comentário inválido',
        ]);
        $result = $this->Comentapautas->save($comment);
        $this->assertFalse($result);
        $this->assertNotEmpty($comment->getErrors()['pauta_id']);
    }
}
