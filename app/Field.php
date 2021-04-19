<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Field extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'field';
    protected $primaryKey = 'fieldid';

    /**
     * Get the block record associated with the field.
     */
    public function block()
    {
        return $this->belongsTo('App\Block', 'blockid');
    }

    /**
     * Get the tab record associated with the field.
     */
    public function tab()
    {
        return $this->belongsTo('App\Tab', 'tabid');
    }
}
