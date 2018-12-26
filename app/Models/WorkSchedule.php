<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WorkSchedule extends Model
{
    protected $table = 'work_schedules';
    protected $guarded = ['id'];

    public function calendars()
    {
        return $this->hasMany('App\Models\Calendar', 'work_schedule_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function location()
    {
        return $this->belongsTo('App\Models\Location');
    }

    public function seats()
    {
        return $this->belongsToMany('App\Models\Seat', 'schedule_seat', 'work_schedule_id')->withPivot('shift');
    }

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getWeekDayAttribute($value)
    {
        return __(Carbon::parse($this->date)->format('l'));
    }
}
