<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable as NotifiableNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'avatar',
        'program_id',
        'workspace_id',
        'position_id',
        'status',
        'lang',
        'role',
        'trainer_id',
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
        return $this->hasMany('App\Models\WorkSchedule', 'user_id');
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
