<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersTable
     */
    protected $Users;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
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
        $config = $this->getTableLocator()->exists('Users') ? [] : ['className' => UsersTable::class];
        $this->Users = $this->getTableLocator()->get('Users', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Users);
        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $user = $this->Users->newEntity([
            'role' => 'admin',
        ]);
        $this->assertNotEmpty($user->getErrors()['username']);
        $this->assertNotEmpty($user->getErrors()['password']);

        $userValid = $this->Users->newEntity([
            'username' => 'newadmin',
            'password' => 'password',
            'role' => 'admin',
        ]);
        $this->assertEmpty($userValid->getErrors());
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        // 'admin' username is already in the fixture
        $user = $this->Users->newEntity([
            'username' => 'admin',
            'password' => 'password',
            'role' => 'admin',
        ]);
        $result = $this->Users->save($user);
        $this->assertFalse($result);
        $this->assertNotEmpty($user->getErrors()['username']);
    }
}
