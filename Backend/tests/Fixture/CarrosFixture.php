<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CarrosFixture
 */
class CarrosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'placa' => ['type' => 'string', 'fixed' => true, 'length' => 8, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'nome_carro' => ['type' => 'string', 'length' => 40, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'cor_carro' => ['type' => 'string', 'length' => 25, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'ano_carro' => ['type' => 'string', 'fixed' => true, 'length' => 4, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null],
        'marca_carro' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'combustivel_carro' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'cliente_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'carros_cliente_id_fkey' => ['type' => 'foreign', 'columns' => ['cliente_id'], 'references' => ['clientes', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'placa' => 'Lorem ',
                'nome_carro' => 'Lorem ipsum dolor sit amet',
                'cor_carro' => 'Lorem ipsum dolor sit a',
                'ano_carro' => 'Lo',
                'marca_carro' => 'Lorem ipsum dolor sit amet',
                'combustivel_carro' => 'Lorem ipsum dolor sit amet',
                'cliente_id' => 1,
            ],
        ];
        parent::init();
    }
}
