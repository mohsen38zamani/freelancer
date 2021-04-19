<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lv1skill extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'lv1skill';
    protected $primaryKey = 'lv1skillid';

    public function attachment()
    {
        return $this->hasOne('App\Attachment','ownerid')->Where('tabid','6');
    }

    public function Skill()
    {
        return $this->hasMany('App\Skill','lv1skillid');
    }
}
