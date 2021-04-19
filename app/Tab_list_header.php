<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tab_list_header extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'tab_list_header';
    protected $primaryKey = 'tab_list_headerid';

    /**
     * Get the tab record associated with the tab_list_header.
     */
    public function tab()
    {
        return $this->belongsTo('App\Tab', 'tabid')->where('isentity', true);
    }
}
