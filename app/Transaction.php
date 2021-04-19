<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'transaction';
    protected $primaryKey = 'transactionid';

    public function user_profile()
    {
        return $this->belongsTo('App\User_profile','user_profileid');
    }
}
