<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'product';
    protected $primaryKey = 'productid';

    /**
     * Get the lv3product record associated with the product.
     */
    public function lv3product()
    {
        return $this->belongsTo('App\Lv3product', 'lv3productid');
    }

    /**
     * Get the stock record associated with the product.
     */
    public function stock()
    {
        return $this->belongsTo('App\Stock', 'stockid');
    }

    /**
     * Get the product_unit record associated with the product.
     */
    public function product_unit()
    {
        return $this->belongsTo('App\Product_unit', 'product_unitid');
    }

    /**
     * Get the inventory record associated with the product.
     */
    public function inventory()
    {
        return $this->hasMany('App\Inventory', 'productid');
    }
}
