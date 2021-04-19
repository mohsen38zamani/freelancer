<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Footermenu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'footermenu';
    protected $primaryKey = 'footermenuid';

    public function Footeritem()
    {
        return $this->hasMany('App\Footeritem','footermenuid');
    }
}
