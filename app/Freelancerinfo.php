<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Freelancerinfo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'freelancerinfo';
    protected $primaryKey = 'freelancerinfoid';
    protected $fillable =['user_profileid'];

    /**
     * Get the user And skill_freelancer record associated with the freelancerinfo.
     */
    public function skill_freelancer()
    {
        return $this->hasMany('App\Skill_freelancer','freelancerinfoid','freelancerinfoid')->with(['skill']);
    }
}
