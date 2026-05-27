<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ComentapautasController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ComentapautasController Test Case
 *
 * @link \App\Controller\ComentapautasController
 */
class ComentapautasControllerTest extends TestCase
{
    use IntegrationTestTrait;

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
            'pauta_id' => 1,
            'comentario' => 'Novo Comentario da Pauta',
        ];
        $this->post('/comentapautas/add', $data);
        $this->assertRedirect(['controller' => 'Pautas', 'action' => 'view', 1]);

        $comentapautasTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Comentapautas');
        $query = $comentapautasTable->find()->where(['comentario' => 'Novo Comentario da Pauta']);
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
            'comentario' => 'Comentario Alterado',
        ];
        $this->post('/comentapautas/edit/1', $data);
        $this->assertRedirect(['controller' => 'Pautas', 'action' => 'view', 1]);

        $comentapautasTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Comentapautas');
        $comment = $comentapautasTable->get(1);
        $this->assertEquals('Comentario Alterado', $comment->comentario);
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
        $this->post('/comentapautas/delete/1');
        $this->assertRedirect(['controller' => 'Pautas', 'action' => 'view', 1]);

        $comentapautasTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Comentapautas');
        $query = $comentapautasTable->find()->where(['id' => 1]);
        $this->assertEquals(0, $query->count());
    }
}
