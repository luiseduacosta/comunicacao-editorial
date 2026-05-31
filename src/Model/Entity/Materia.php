<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Materia Entity
 *
 * @property int $id
 * @property int|null $pauta_id
 * @property string $titulo
 * @property string $conteudo
 * @property bool $arquivar
 * @property bool $informandes
 * @property bool $publicar
 * @property string|null $anexos
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Pauta $pauta
 * @property \App\Model\Entity\Observaco[] $observacoes
 * @property \App\Model\Entity\Tag[] $tags
 */
class Materia extends Entity
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
        'pauta_id' => true,
        'titulo' => true,
        'conteudo' => true,
        'arquivar' => true,
        'informandes' => true,
        'publicar' => true,
        'anexos' => true,
        'created' => true,
        'modified' => true,
        'pauta' => true,
        'observacoes' => true,
        'tags' => true,
    ];
}
