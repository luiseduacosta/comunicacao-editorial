<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ObservacoesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ObservacoesController Test Case
 *
 * @link \App\Controller\ObservacoesController
 */
class ObservacoesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Users',
        'app.Observacoes',
        'app.Materias',
        'app.Pautas',
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
     * Test add method
     *
     * @return void
     */
    public function testAdd(): void
    {
        $this->login();
        $this->enableCsrfToken();
        $data = [
            'materia_id' => 1,
            'observacao' => 'Nova Observacao da Materia',
        ];
        $this->post('/observacoes/add', $data);
        $this->assertRedirect(['controller' => 'Materias', 'action' => 'view', 1]);

        $observacoesTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Observacoes');
        $query = $observacoesTable->find()->where(['observacao' => 'Nova Observacao da Materia']);
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
            'observacao' => 'Observacao Alterada',
        ];
        $this->post('/observacoes/edit/1', $data);
        $this->assertRedirect(['controller' => 'Materias', 'action' => 'view', 1]);

        $observacoesTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Observacoes');
        $obs = $observacoesTable->get(1);
        $this->assertEquals('Observacao Alterada', $obs->observacao);
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
        $this->post('/observacoes/delete/1');
        $this->assertRedirect(['controller' => 'Materias', 'action' => 'view', 1]);

        $observacoesTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Observacoes');
        $query = $observacoesTable->find()->where(['id' => 1]);
        $this->assertEquals(0, $query->count());
    }
}
