<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Result Entity
 *
 * @property int $job_processing_id
 * @property int $test_type_id
 * @property int $test_counter
 * @property string|null $number
 * @property string|null $country
 * @property \Cake\I18n\FrozenTime|null $start_time
 * @property \Cake\I18n\FrozenTime|null $end_time
 * @property \Cake\I18n\FrozenTime|null $connect_time
 * @property float|null $score
 * @property string|null $url
 * @property int|null $added_by
 * @property \Cake\I18n\FrozenTime|null $added_on
 */
class Result extends Entity
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
        'number' => true,
        'country' => true,
        'start_time' => true,
        'end_time' => true,
        'connect_time' => true,
        'score' => true,
        'url' => true,
        'added_by' => true,
        'added_on' => true,
    ];
}
