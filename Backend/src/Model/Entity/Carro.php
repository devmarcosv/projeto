<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Carro Entity
 *
 * @property int $id
 * @property string|null $placa
 * @property string $nome_carro
 * @property string $cor_carro
 * @property string $ano_carro
 * @property string|null $marca_carro
 * @property string|null $combustivel_carro
 * @property int|null $cliente_id
 *
 * @property \App\Model\Entity\Cliente $cliente
 * @property \App\Model\Entity\Reviso[] $revisoes
 */
class Carro extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'placa' => true,
        'nome_carro' => true,
        'cor_carro' => true,
        'ano_carro' => true,
        'marca_carro' => true,
        'combustivel_carro' => true,
        'cliente_id' => true,
        'cliente' => true,
        'revisoes' => true,
    ];
}
