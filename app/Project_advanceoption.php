<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project_advanceoption extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'project_advanceoption';
    protected $primaryKey = 'project_advanceoptionid';
    protected $fillable =['projectid','advanceoptionid'];

    /**
     * Get the advanceoption record associated with the project_advanceoption.
     */
    public function advanceoption()
    {
        return $this->belongsTo('App\Advanceoption', 'advanceoptionid');
    }

    /**
     * Get the project record associated with the project_advanceoption.
     */
    public function project()
    {
        return $this->belongsTo('App\Project', 'projectid');
    }
}
