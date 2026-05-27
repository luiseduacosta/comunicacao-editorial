<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PautasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PautasTable Test Case
 */
class PautasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PautasTable
     */
    protected $Pautas;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Pautas',
        'app.Comentapautas',
        'app.Materias',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Pautas') ? [] : ['className' => PautasTable::class];
        $this->Pautas = $this->getTableLocator()->get('Pautas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Pautas);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\PautasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $pauta = $this->Pautas->newEntity([
            'descricao' => 'Teste pauta',
            'arquivar' => false,
            'informandes' => false,
        ]);
        $this->assertNotEmpty($pauta->getErrors()['data']);

        $pautaValid = $this->Pautas->newEntity([
            'data' => '2026-05-27',
            'descricao' => 'Teste pauta',
            'arquivar' => false,
            'informandes' => false,
        ]);
        $this->assertEmpty($pautaValid->getErrors());
    }
}
