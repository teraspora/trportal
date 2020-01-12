<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResultsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResultsTable Test Case
 */
class ResultsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ResultsTable
     */
    public $Results;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Results',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Results') ? [] : ['className' => ResultsTable::class];
        $this->Results = TableRegistry::getTableLocator()->get('Results', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Results);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
