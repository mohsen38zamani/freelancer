<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portfolio extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'portfolio';
    protected $primaryKey = 'portfolioid';

    public function attachment()
    {
        return $this->hasOne('App\Attachment','ownerid')->Where('tabid','24');
    }

    public function attachments()
    {
        return $this->hasMany('App\Attachment','ownerid')->Where('tabid','24');
    }

    public function portfolio_skill()
    {
        return $this->hasMany('App\Portfolio_skill','portfolio_skillid');
    }
}
