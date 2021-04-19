<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'faq';
    protected $primaryKey = 'faqid';

    /**
     * Get the role record associated with the faq.
     */
    public function role()
    {
        return $this->belongsTo('App\Role','roleid','roleid');
    }
}
