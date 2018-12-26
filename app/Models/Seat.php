<?php

namespace App\Models;

use App\Models\User;
use App\Models\Location;
use App\Models\WorkSchedule;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = [
        'name',
        'location_id',
        'user_id',
        'usable',
    ];
    public $timestamps = false;

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function workSchedules()
    {
        return $this->belongsToMany(WorkSchedule::class, 'schedule_seat', 'seat_id')->withPivot('shift');
    }
}
