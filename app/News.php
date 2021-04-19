<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'news';
    protected $primaryKey = 'newsid';


    /**
     * Get the lv1skill user_profile associated with the news.
     */
    public function user_profile()
    {
        return $this->belongsTo('App\User_profile', 'user_profileid');
    }
}
