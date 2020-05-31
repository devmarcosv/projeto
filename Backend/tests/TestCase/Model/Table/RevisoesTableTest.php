<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RevisoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RevisoesTable Test Case
 */
class RevisoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RevisoesTable
     */
    public $Revisoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Revisoes',
        'app.Carros',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Revisoes') ? [] : ['className' => RevisoesTable::class];
        $this->Revisoes = TableRegistry::getTableLocator()->get('Revisoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Revisoes);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
