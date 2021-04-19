<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_profile extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'user_profile';
    protected $primaryKey = 'user_profileid';
    protected $fillable = ['userid','username'];

    /**
     * Get the user record associated with the user_profile.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'userid', 'id');
    }

    /**
     * Get the user And country record associated with the user_profile.
     */
    public function country()
    {
        return $this->belongsTo('App\Country','countryid')->with(['mainland', 'attachment']);
    }

    /**
     * Get the user And freelancerinfo record associated with the user_profile.
     */
    public function freelancerinfo()
    {
        return $this->belongsTo('App\Freelancerinfo','user_profileid','user_profileid')->with(['skill_freelancer']);
    }

    /**
     * Get the user And attachment record associated with the user_profile.
     */
    public function attachment()
    {
        return $this->hasOne('App\Attachment','ownerid')->Where('tabid','2');
    }

    /**
     * Get the user And attachment record associated with the user_profile.
     */
    public function profile_img()
    {
        return $this->hasOne('App\Attachment','ownerid')->Where('tabid','2')->Where('title','profile');
    }

    /**
     * Get the user And attachment record associated with the user_profile.
     */
    public function banner_img()
    {
        return $this->hasOne('App\Attachment','ownerid')->Where('tabid','2')->Where('title','banner');
    }

    /**
     * Get the user And role record associated with the user_profile.
     */
    public function userole()
    {
        return $this->belongsTo('App\User', 'userid', 'id')->with('role');
    }

    /**
     * Get the user education associated with the user_profile.
     */
    public function education()
    {
        return $this->hasMany('App\Education', 'user_profileid', 'user_profileid')->with('country');
    }

    /**
     * Get the user job_experience associated with the user_profile.
     */
    public function job_experience()
    {
        return $this->hasMany('App\Job_experience', 'user_profileid', 'user_profileid');
    }

    /**
     * Get the user qualification associated with the user_profile.
     */
    public function qualification()
    {
        return $this->hasMany('App\Qualification', 'user_profileid', 'user_profileid');
    }

    /**
     * Get the user publication associated with the user_profile.
     */
    public function publication()
    {
        return $this->hasMany('App\Publication', 'user_profileid', 'user_profileid');
    }

    /**
     * Get the user user_creditcard associated with the user_profile.
     */
    public function user_creditcard()
    {
        return $this->hasMany('App\User_creditcard', 'user_profileid', 'user_profileid');
    }

    /**
     * Get the user verify_user associated with the user_profile.
     */
    public function verify_user()
    {
        return $this->hasOne('App\Verify_user', 'user_profileid', 'user_profileid');
    }

    /**
     * Get the user user_verification_items associated with the user_profile.
     */
    public function user_verification_items()
    {
        return $this->hasOne('App\User_verification_items', 'user_profileid', 'user_profileid');
    }

    /**
     * Get the user projects associated with the user_profile.
     */
    public function projects()
    {
        return $this->hasMany('App\Project', 'user_profileid', 'user_profileid');
    }

    /**
     * Get the user transaction associated with the user_profile.
     */
    public function transaction()
    {
        return $this->hasMany('App\Transaction', 'user_profileid', 'user_profileid');
    }

}
