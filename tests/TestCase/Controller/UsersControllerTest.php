<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\UsersController Test Case
 *
 * @link \App\Controller\UsersController
 */
class UsersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Users',
        'app.Comentapautas',
        'app.Observacoes',
    ];

    /**
     * Helper to authenticate
     */
    protected function loginAsAdmin(): void
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
        $this->loginAsAdmin();
        $this->get('/users');
        $this->assertResponseOk();
        $this->assertResponseContains('admin');
        $this->assertResponseContains('user');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView(): void
    {
        $this->loginAsAdmin();
        $this->get('/users/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('admin');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd(): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();
        $data = [
            'username' => 'newuser',
            'password' => 'newpassword',
            'role' => 'user',
        ];
        $this->post('/users/add', $data);
        $this->assertRedirect(['action' => 'index']);

        $usersTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Users');
        $query = $usersTable->find()->where(['username' => 'newuser']);
        $this->assertEquals(1, $query->count());
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit(): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();
        $data = [
            'username' => 'admin_edited',
            'role' => 'admin',
        ];
        $this->post('/users/edit/1', $data);
        $this->assertRedirect(['action' => 'index']);

        $usersTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Users');
        $user = $usersTable->get(1);
        $this->assertEquals('admin_edited', $user->username);
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete(): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();
        $this->post('/users/delete/2');
        $this->assertRedirect(['action' => 'index']);

        $usersTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Users');
        $query = $usersTable->find()->where(['id' => 2]);
        $this->assertEquals(0, $query->count());
    }

    /**
     * Test login method
     *
     * @return void
     */
    public function testLogin(): void
    {
        // 1. Check login page renders
        $this->get('/users/login');
        $this->assertResponseOk();
        $this->assertResponseContains('Acessar');

        // 2. Submit valid credentials
        $this->enableCsrfToken();
        $this->post('/users/login', [
            'username' => 'admin',
            'password' => 'password',
        ]);
        $this->assertResponseCode(302);
    }
}
