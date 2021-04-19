<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Verify_user extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'verify_user';
    protected $primaryKey = 'verify_userid';

    protected $guarded = [];

    /**
     * Get the user user_profile associated with the verify_user.
     */
    public function user_profile()
    {
        return $this->belongsTo('App\User_profile', 'user_profileid', 'user_profileid')->with('user_verification_items');
    }
}
