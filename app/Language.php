<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'translator_languages';
    protected $primaryKey = 'id';
}
