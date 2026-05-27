<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\MateriasController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\MateriasController Test Case
 *
 * @link \App\Controller\MateriasController
 */
class MateriasControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Users',
        'app.Materias',
        'app.Pautas',
        'app.Observacoes',
        'app.Tags',
        'app.MateriasTags',
    ];

    /**
     * Helper to authenticate
     */
    protected function login(): void
    {
        $this->session([
            'Auth' => [
                'id' => 1,
                'username' => 'admin',
                'role' => 'admin',
            ]
        ]);
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex(): void
    {
        $this->login();
        $this->get('/materias');
        $this->assertResponseOk();
        $this->assertResponseContains('Matérias');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView(): void
    {
        $this->login();
        $this->get('/materias/view/1');
        $this->assertResponseOk();
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd(): void
    {
        $this->login();
        $this->enableCsrfToken();
        $data = [
            'pauta_id' => 1,
            'titulo' => 'Nova Matéria de Teste',
            'conteudo' => 'Texto da matéria',
            'data' => '2026-05-27',
            'tags' => ['_ids' => [1]],
        ];
        $this->post('/materias/add', $data);
        $this->assertRedirect(['action' => 'index']);

        $materiasTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Materias');
        $query = $materiasTable->find()->where(['titulo' => 'Nova Matéria de Teste']);
        $this->assertEquals(1, $query->count());
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit(): void
    {
        $this->login();
        $this->enableCsrfToken();
        $data = [
            'titulo' => 'Matéria Alterada',
        ];
        $this->post('/materias/edit/1', $data);
        $this->assertRedirect(['action' => 'index']);

        $materiasTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Materias');
        $materia = $materiasTable->get(1);
        $this->assertEquals('Matéria Alterada', $materia->titulo);
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete(): void
    {
        $this->login();
        $this->enableCsrfToken();
        $this->post('/materias/delete/1');
        $this->assertRedirect(['action' => 'index']);

        $materiasTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Materias');
        $query = $materiasTable->find()->where(['id' => 1]);
        $this->assertEquals(0, $query->count());
    }
}
