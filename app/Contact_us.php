<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact_us extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'contact_us';
    protected $primaryKey = 'contact_usid';

    public function lv1skill()
    {
        return $this->hasOne('App\Lv1skill','lv1skillid');
    }
}
