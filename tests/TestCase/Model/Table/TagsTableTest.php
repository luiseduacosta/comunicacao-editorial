<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TagsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TagsTable Test Case
 */
class TagsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TagsTable
     */
    protected $Tags;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Tags',
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
        $config = $this->getTableLocator()->exists('Tags') ? [] : ['className' => TagsTable::class];
        $this->Tags = $this->getTableLocator()->get('Tags', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Tags);
        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $tag = $this->Tags->newEntity([]);
        $this->assertNotEmpty($tag->getErrors()['nome']);

        $tagValid = $this->Tags->newEntity([
            'nome' => 'Nova Tag',
        ]);
        $this->assertEmpty($tagValid->getErrors());
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        // 'Lorem ipsum dolor sit amet' is already in fixture for Tag
        $tag = $this->Tags->newEntity([
            'nome' => 'Lorem ipsum dolor sit amet',
        ]);
        $result = $this->Tags->save($tag);
        $this->assertFalse($result);
        $this->assertNotEmpty($tag->getErrors()['nome']);
    }
}
