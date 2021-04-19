<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Footeritem extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'footeritem';
    protected $primaryKey = 'footeritemid';

    /**
     * Get the footermenu record associated with the footeritem.
     */
    public function footermenu()
    {
        return $this->belongsTo('App\Footermenu', 'footermenuid');
    }
}
