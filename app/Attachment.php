<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'attachment';
    protected $primaryKey = 'attachmentid';

    public function project(){
        return $this->hasOne('App\Project','projectid','ownerid');
    }
}
