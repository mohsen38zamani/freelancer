<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wage extends Model
{

    use SoftDeletes;
    protected $table = 'wage';
    protected $primaryKey = 'wageid';

    public function project()
    {
        return $this->hasOne('App\Project','wageid');
    }
    public function currency(){
        return $this->belongsTo('App\Currency','currencyid');
    }
}
