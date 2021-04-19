<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roll_bill extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'roll_bill';
    protected $primaryKey = 'roll_billid';
    protected $fillable = ['target','customid_lv1','customid_lv2'];
}
