<?php
namespace App\Model\Entity;
use Cake\Collection\Collection;
use Cake\ORM\Entity;
use Cake\I18n\Time;

/**
 * Result Entity
 *
 * @property int $job_processing_uid
 * @property int $test_type_uid
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
        'job_processing_uid' => true,
        'test_type_uid' => true,
        'test_counter' => true,
        'number' => true,
        'country' => true,
        'start_time' => true,
        'end_time' => true,
        'connect_time' => true,
        'score' => true,
        'url' => true,
        'added_by' => true,
        'added_on' => true,
        'id_str' => true,
        'duration' => true
    ];

    // These hooks create "computed properties", so we can refer to `$result->id_str`
    // and `$result->duration' in templates.    Ref. Book p.67.
    protected function _getIdStr() {
        if (isset($this->_properties['id_str'])) {
            return $this->_properties['id_str'];
        }
        return (string)($this->job_processing_uid) . '_' . (string)($this->test_counter) . '_' . (string)($this->test_type_uid);
    }

    protected function _getDuration() {
        if (isset($this->_properties['duration'])) {
            return $this->_properties['duration'];
        }
        // $srt = new Time($this->start_time); 
        $end = new Time($this->end_time);
        $con = new Time($this->connect_time);
        return ($end->diff($con))->format('%H:%I:%S');
    }

}
