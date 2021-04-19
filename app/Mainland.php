<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mainland extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'mainland';
    protected $primaryKey = 'mainlandid';

    public function Country(){
        return $this->hasMany('App\Country','mainlandid');
    }
}
