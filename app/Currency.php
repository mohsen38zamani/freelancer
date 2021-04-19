<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'currency';
    protected $primaryKey = 'currencyid';

    public function wage()
    {
        return $this->hasMany('App\Wage','currencyid');
    }
}
