<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    use SoftDeletes;
    /**
     * [$dates description]
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * [$fillable description]
     * @var [type]
     */
    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    /**
     * Get roles
     * @return [type] [description]
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'permission_role', 'permission_id', 'role_id');
    }
}
