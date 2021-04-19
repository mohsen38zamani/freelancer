<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tab extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tab';
    protected $primaryKey = 'tabid';
}
