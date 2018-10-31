<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
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
}
