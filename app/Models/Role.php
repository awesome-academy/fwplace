<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
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
     * Tạo liên kết với bảng role_user qua role_id
     * @return [type] [description]
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'role_user', 'role_id', 'user_id');
    }

    /**
     * Tạo liên kết với bảng permission_user qua role_id
     * @return [type] [description]
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission', 'permission_role', 'role_id', 'permission_id');
    }

    public function scopeGetIdRoleTrainee($query)
    {
        return $this->select('id')->where('name', 'like', 'trainee')->first();
    }
}
