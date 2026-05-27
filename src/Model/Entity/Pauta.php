<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pauta Entity
 *
 * @property int $id
 * @property \Cake\I18n\Date $data
 * @property string|null $titulo
 * @property string|null $descricao
 * @property string|null $anexos
 * @property string|null $observacoes
 * @property bool $arquivar
 * @property bool $informandes
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Comentapauta[] $comentapautas
 * @property \App\Model\Entity\Materia[] $materias
 */
class Pauta extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'data' => true,
        'titulo' => true,
        'descricao' => true,
        'anexos' => true,
        'observacoes' => true,
        'arquivar' => true,
        'informandes' => true,
        'created' => true,
        'modified' => true,
        'comentapautas' => true,
        'materias' => true,
    ];
}
