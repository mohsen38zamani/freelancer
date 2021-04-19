<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assistant_setting extends Model
{
    use SoftDeletes;
    protected $table = 'assistant_setting';
    protected $primaryKey = 'assistant_settingid';

    public function currency()
    {
        return $this->belongsTo('App\Currency','currencyid');
    }
}
