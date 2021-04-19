<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_verification_items extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'user_verification_items';
    protected $primaryKey = 'user_verification_itemsid';
    protected $fillable =['user_profileid'];

    /**
     * Get the user user_profile associated with the user_verification_items.
     */
    public function user_profile()
    {
        return $this->hasOne('App\User_profile', 'user_profileid', 'user_profileid');
    }
}
