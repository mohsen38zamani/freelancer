<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill_requirment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'skill_requirment';
    protected $primaryKey = 'skill_requirmentid';

    /**
     * Get the skill record associated with the skill_requirment.
     */
    public function skill()
    {
        return $this->belongsTo('App\Skill', 'skillid');
    }

    /**
     * Get the project record associated with the skill_requirment.
     */
    public function project()
    {
        return $this->belongsTo('App\Project', 'projectid');
    }
}
