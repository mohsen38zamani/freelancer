<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'slider';
    protected $primaryKey = 'sliderid';

    /**
     * Get the attachment record associated with the slider.
     */
    public function attachment(){
        return $this->hasOne('App\Attachment','ownerid')->orWhere('tabid','17');
    }

}
