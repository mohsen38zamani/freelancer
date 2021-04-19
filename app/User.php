<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'roleid', 'provider', 'provider_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the role record associated with the user.
     */
    public function role()
    {
        return $this->belongsTo('App\Role', 'roleid');
    }

    /**
     * Get the role record associated with the user.
     */
    public function user_profile()
    {
        return $this->hasOne('App\User_profile', 'userid');
    }

    /**
     * Get the role record associated with the user.
     */
    public function user_profile_img()
    {
        return $this->hasOne('App\User_profile', 'userid', 'id')->with('profile_img');
    }

    /**
     * Get the messages record associated with the user.
     */
    public function messages()
    {
        return $this->hasMany(\App\Message::class);
    }

    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }
}
