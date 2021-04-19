<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item_menu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'item_menu';
    protected $primaryKey = 'item_menuid';

    /**
     * Get the menu record associated with the item_menu.
     */
    public function menu()
    {
        return $this->belongsTo('App\Menu', 'menuid');
    }
}
