<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'project';
    protected $primaryKey = 'projectid';

    public function wage()
    {
        return $this->hasOne('App\Wage','wageid','wageid')->with('currency');
    }

    public function assistant_setting()
    {
        return $this->hasOne('App\Assistant_setting','assistant_settingid','assistant_settingid');
    }

    public function attachment()
    {
        return $this->hasMany('App\Attachment','ownerid')->Where('tabid','25');
    }

    public function project_advanceoption()
    {
        return $this->hasMany('App\Project_advanceoption','projectid');
    }

    public function skill_requirment()
    {
        return $this->hasMany('App\Skill_requirment','projectid')->with('skill');
    }

    public function user_profile()
    {
        return $this->hasOne('App\User_profile','user_profileid','user_profileid')->with('country');
    }

    public function manage_project()
    {
        return $this->hasOne('App\Manage_project','projectid','projectid')->with('bids_project');
    }

}
