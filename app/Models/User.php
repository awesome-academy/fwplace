<?php

namespace App\Models;

use App\Models\Seat;
use App\Models\WorkSchedule;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, EntrustUserTrait {
        SoftDeletes::restore insteadof EntrustUserTrait;

        EntrustUserTrait::restore insteadof SoftDeletes;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'seat_id',
        'name',
        'email',
        'password',
        'avatar',
        'program_id',
        'workspace_id',
        'position_id',
        'status',
        'lang',
        'role',
        'seat_id',
        'trainer_id',
        'batch_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function trainees()
    {
        return $this->hasMany(User::class);
    }

    public function trainer()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo('App\Models\Program');
    }

    public function workspace()
    {
        return $this->belongsTo('App\Models\Workspace');
    }

    public function position()
    {
        return $this->belongsTo('App\Models\Position');
    }

    public function workSchedules()
    {
        return $this->hasMany(WorkSchedule::class, 'user_id');
    }

    /**
     * Get roles many to many
     * @return [type] [description]
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'role_user', 'user_id', 'role_id');
    }

    public function getAvatarUserAttribute()
    {
        if ($this->avatar) {
            return asset(config('site.user.display-image') . $this->avatar);
        }

        return asset(config('site.default-image'));
    }

    public function scopeFilterUser($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }

    public function getShiftByDate($date)
    {
        $workSchedule = $this->workSchedules()
            ->where('date', $date)
            ->where('shift', '!=', config('site.shift.off'))
            ->first();
        if ($workSchedule) {
            return config('site.shift_filter')[$workSchedule->shift];
        }

        return null;
    }
}
