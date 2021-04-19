<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lv2skill extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'lv2skill';
    protected $primaryKey = 'lv2skillid';

    /**
     * Get the lv1skill record associated with the lv2skill.
     */
    public function lv1skill()
    {
        return $this->belongsTo('App\Lv1skill', 'lv1skillid');
    }
}
