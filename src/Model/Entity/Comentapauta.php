<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Comentapauta Entity
 *
 * @property int $id
 * @property int $pauta_id
 * @property int|null $user_id
 * @property string $comentario
 * @property string|null $autor
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Pauta $pauta
 * @property \App\Model\Entity\User $user
 */
class Comentapauta extends Entity
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
        'user_id' => true,
        'comentario' => true,
        'autor' => true,
        'created' => true,
        'modified' => true,
        'pauta' => true,
        'user' => true,
    ];
}
