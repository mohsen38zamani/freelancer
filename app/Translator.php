<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Translator extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'translator_translations';
    protected $primaryKey = 'id';
}
