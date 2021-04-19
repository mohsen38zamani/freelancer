<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permission';
    protected $primaryKey = 'permissionid';

    /**
     * Get the role record associated with the permission.
     */
    public function role()
    {
        return $this->belongsTo('App\Role', 'roleid');
    }

    /**
     * Get the tab record associated with the permission.
     */
    public function tab()
    {
        return $this->belongsTo('App\Tab', 'tabid');
    }
}
