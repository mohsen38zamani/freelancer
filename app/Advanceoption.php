<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advanceoption extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'advanceoption';
    protected $primaryKey = 'advanceoptionid';

    /**
     * Get the currency record associated with the advanceoption.
     */
    public function currency()
    {
        return $this->belongsTo('App\Currency', 'currencyid');
    }

}
