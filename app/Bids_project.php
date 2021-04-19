<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bids_project extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'bids_project';
    protected $primaryKey = 'bids_projectid';
    protected $fillable = ['projectid','user_profileid','bid','period_time','type','describe'];

    public function user_profile()
    {
        return $this->hasOne('App\User_profile','user_profileid','user_profileid')->with('country','attachment','freelancerinfo');
    }

    public function mile_stone()
    {
        return $this->hasMany('App\Mile_stone','bids_projectid','bids_projectid');
    }

    public function project()
    {
        return $this->hasMany('App\Project','projectid','projectid')->with('user_profile','wage');
    }

    public function manage_project()
    {
        return $this->hasOne('App\Manage_project','bids_projectid','bids_projectid');
    }
}
