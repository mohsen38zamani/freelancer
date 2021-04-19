<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'skill';
    protected $primaryKey = 'skillid';

    /**
     * Get the lv1skill record associated with the skill.
     */
    public function lv1skill()
    {
        return $this->belongsTo('App\Lv1skill', 'lv1skillid');
    }

    public function get_CrowdFavorites()
    {
        return $this->hasOne('App\Attachment','ownerid')->Where('tabid','8');
    }

    /**
     * Get the user And skill_freelancer record associated with the skill.
     */
    public function skill_freelancer()
    {
        return $this->belongsTo('App\Skill_freelancer','skillid','skillid');
    }
}
