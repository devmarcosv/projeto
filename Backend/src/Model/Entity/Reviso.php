<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Reviso Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate $data_revisao
 * @property string $descricao_revisao
 * @property float $valor_revisao
 * @property int|null $carro_id
 *
 * @property \App\Model\Entity\Carro $carro
 */
class Reviso extends Entity
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
        'data_revisao' => true,
        'descricao_revisao' => true,
        'valor_revisao' => true,
        'carro_id' => true,
        'carro' => true,
    ];
}
