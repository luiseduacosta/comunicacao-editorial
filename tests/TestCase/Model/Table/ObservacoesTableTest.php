<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ObservacoesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ObservacoesTable Test Case
 */
class ObservacoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ObservacoesTable
     */
    protected $Observacoes;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Observacoes',
        'app.Materias',
        'app.Users',
        'app.Pautas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Observacoes') ? [] : ['className' => ObservacoesTable::class];
        $this->Observacoes = $this->getTableLocator()->get('Observacoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Observacoes);
        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $obs = $this->Observacoes->newEntity([]);
        $this->assertNotEmpty($obs->getErrors()['observacao']);

        $obsValid = $this->Observacoes->newEntity([
            'materia_id' => 1,
            'user_id' => 1,
            'observacao' => 'Nova Observação',
        ]);
        $this->assertEmpty($obsValid->getErrors());
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        // materia_id 999 does not exist
        $obs = $this->Observacoes->newEntity([
            'materia_id' => 999,
            'user_id' => 1,
            'observacao' => 'Observação inválida',
        ]);
        $result = $this->Observacoes->save($obs);
        $this->assertFalse($result);
        $this->assertNotEmpty($obs->getErrors()['materia_id']);
    }
}
