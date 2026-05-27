<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MateriasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MateriasTable Test Case
 */
class MateriasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MateriasTable
     */
    protected $Materias;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Materias',
        'app.Pautas',
        'app.Observacoes',
        'app.Tags',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Materias') ? [] : ['className' => MateriasTable::class];
        $this->Materias = $this->getTableLocator()->get('Materias', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Materias);
        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $materia = $this->Materias->newEntity([
            'arquivar' => false,
            'informandes' => false,
        ]);
        $this->assertNotEmpty($materia->getErrors()['titulo']);
        $this->assertNotEmpty($materia->getErrors()['conteudo']);
        $this->assertNotEmpty($materia->getErrors()['data']);

        $materiaValid = $this->Materias->newEntity([
            'titulo' => 'Materia de Teste',
            'conteudo' => 'Corpo do texto',
            'data' => '2026-05-27',
            'arquivar' => false,
            'informandes' => false,
        ]);
        $this->assertEmpty($materiaValid->getErrors());
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        // pauta_id 999 does not exist
        $materia = $this->Materias->newEntity([
            'pauta_id' => 999,
            'titulo' => 'Materia de Teste',
            'conteudo' => 'Corpo do texto',
            'data' => '2026-05-27',
            'arquivar' => false,
            'informandes' => false,
        ]);
        $result = $this->Materias->save($materia);
        $this->assertFalse($result);
        $this->assertNotEmpty($materia->getErrors()['pauta_id']);
    }
}
