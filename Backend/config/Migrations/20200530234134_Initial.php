<?php
use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{
    public function up()
    {

        $this->table('carros')
            ->addColumn('placa', 'string', [
                'default' => null,
                'limit' => 8,
                'null' => true,
            ])
            ->addColumn('nome_carro', 'string', [
                'default' => null,
                'limit' => 40,
                'null' => false,
            ])
            ->addColumn('cor_carro', 'string', [
                'default' => null,
                'limit' => 25,
                'null' => false,
            ])
            ->addColumn('ano_carro', 'string', [
                'default' => null,
                'limit' => 4,
                'null' => false,
            ])
            ->addColumn('marca_carro', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('combustivel_carro', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('cliente_id', 'integer', [
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addIndex(
                [
                    'cliente_id',
                ]
            )
            ->create();

        $this->table('clientes')
            ->addColumn('nome_cliente', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('sexo_cliente', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('idade_cliente', 'smallinteger', [
                'default' => null,
                'limit' => 5,
                'null' => false,
            ])
            ->create();

        $this->table('revisoes')
            ->addColumn('data_revisao', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('descricao_revisao', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('valor_revisao', 'float', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('carro_id', 'integer', [
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addIndex(
                [
                    'carro_id',
                ]
            )
            ->create();

        $this->table('carros')
            ->addForeignKey(
                'cliente_id',
                'clientes',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('revisoes')
            ->addForeignKey(
                'carro_id',
                'carros',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();
    }

    public function down()
    {
        $this->table('carros')
            ->dropForeignKey(
                'cliente_id'
            )->save();

        $this->table('revisoes')
            ->dropForeignKey(
                'carro_id'
            )->save();

        $this->table('carros')->drop()->save();
        $this->table('clientes')->drop()->save();
        $this->table('revisoes')->drop()->save();
    }
}
