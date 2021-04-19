<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manage_project extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'manage_project';
    protected $primaryKey = 'manage_projectid';
    protected $fillable = ['projectid','bids_projectid','start_date','status_project','end_date'];


    public function bids_project()
    {
        return $this->hasOne('\App\Bids_project','bids_projectid','bids_projectid')->with('user_profile');
    }
}
