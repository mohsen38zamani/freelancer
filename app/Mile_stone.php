<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mile_stone extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'mile_stone';
    protected $primaryKey = 'mile_stoneid';

    public function bids_project()
    {
        return $this->hasOne('\App\Bids_project','bids_projectid','bids_projectid')->with('user_profile');
    }
}
