<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\TagsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\TagsController Test Case
 *
 * @link \App\Controller\TagsController
 */
class TagsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Users',
        'app.Tags',
        'app.Materias',
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
        $this->get('/tags');
        $this->assertResponseOk();
        $this->assertResponseContains('Tags');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView(): void
    {
        $this->login();
        $this->get('/tags/view/1');
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
            'nome' => 'Nova Tag de Teste',
        ];
        $this->post('/tags/add', $data);
        $this->assertRedirect(['action' => 'index']);

        $tagsTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Tags');
        $query = $tagsTable->find()->where(['nome' => 'Nova Tag de Teste']);
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
            'nome' => 'Tag Alterada',
        ];
        $this->post('/tags/edit/1', $data);
        $this->assertRedirect(['action' => 'index']);

        $tagsTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Tags');
        $tag = $tagsTable->get(1);
        $this->assertEquals('Tag Alterada', $tag->nome);
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
        $this->post('/tags/delete/1');
        $this->assertRedirect(['action' => 'index']);

        $tagsTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Tags');
        $query = $tagsTable->find()->where(['id' => 1]);
        $this->assertEquals(0, $query->count());
    }
}
