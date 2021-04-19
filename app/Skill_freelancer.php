<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill_freelancer extends Model
{
    use SoftDeletes;
    protected $table = 'skill_freelancer';
    protected $primaryKey = 'skill_freelancerid';
    protected $fillable =['freelancerinfoid', 'lv1skillid', 'skillid'];

    /**
     * Get the user And skill_freelancer record associated with the skill_freelancer.
     */
    public function skill()
    {
        return $this->belongsTo('App\Skill','skillid','skillid');
    }
}
