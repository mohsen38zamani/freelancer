<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Education extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'education';
    protected $primaryKey = 'educationid';

    /**
     * Get the user country associated with the education.
     */
    public function country()
    {
        return $this->hasOne('App\Country', 'countryid', 'countryid');
    }
}
