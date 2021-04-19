<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menu';
    protected $primaryKey = 'menuid';

    /**
     * Get the item_menu record associated with the menu.
     */
    public function item_menu()
    {
        return $this->hasMany('App\Item_menu', 'menuid');
    }
}
