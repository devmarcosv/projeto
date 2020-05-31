<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cliente Entity
 *
 * @property int $id
 * @property string $nome_cliente
 * @property string $sexo_cliente
 * @property int $idade_cliente
 *
 * @property \App\Model\Entity\Carro[] $carros
 */
class Cliente extends Entity
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
        'nome_cliente' => true,
        'sexo_cliente' => true,
        'idade_cliente' => true,
        'carros' => true,
    ];
}
