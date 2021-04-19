<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'country';
    protected $primaryKey = 'countryid';

    /**
     * Get the mainland record associated with the country.
     */
    public function mainland()
    {
        return $this->belongsTo('App\Mainland', 'mainlandid');
    }

    /**
     * Get the currency record associated with the country.
     */
    public function currency()
    {
        return $this->belongsTo('App\Currency', 'currencyid');
    }

    /**
     * Get the user And attachment record associated with the country.
     */
    public function attachment()
    {
        return $this->hasOne('App\Attachment','ownerid')->Where('tabid','10');
    }
}
