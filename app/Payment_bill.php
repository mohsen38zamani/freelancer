<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment_bill extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'payment_bill';
    protected $primaryKey = 'payment_billid';
    protected $fillable = ['roll_billid','price','state_pay'];
}
