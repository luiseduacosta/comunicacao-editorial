<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\PautasController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\PautasController Test Case
 *
 * @link \App\Controller\PautasController
 */
class PautasControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Users',
        'app.Pautas',
        'app.Comentapautas',
        'app.Materias',
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
        $this->get('/pautas');
        $this->assertResponseOk();
        $this->assertResponseContains('Pautas');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView(): void
    {
        $this->login();
        $this->get('/pautas/view/1');
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
            'data' => '2026-05-27',
            'descricao' => 'Nova Pauta de Teste',
            'detalhes' => 'Detalhes da pauta',
            'arquivado' => 0,
            'publicada_site' => 1,
            'publicada_newsletter' => 0,
        ];
        $this->post('/pautas/add', $data);
        $this->assertRedirect(['action' => 'index']);

        $pautasTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Pautas');
        $query = $pautasTable->find()->where(['descricao' => 'Nova Pauta de Teste']);
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
            'descricao' => 'Pauta Alterada',
        ];
        $this->post('/pautas/edit/1', $data);
        $this->assertRedirect(['action' => 'index']);

        $pautasTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Pautas');
        $pauta = $pautasTable->get(1);
        $this->assertEquals('Pauta Alterada', $pauta->descricao);
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
        $this->post('/pautas/delete/1');
        $this->assertRedirect(['action' => 'index']);

        $pautasTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Pautas');
        $query = $pautasTable->find()->where(['id' => 1]);
        $this->assertEquals(0, $query->count());
    }
}
