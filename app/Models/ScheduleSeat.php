<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleSeat extends Model
{
    protected $table = 'schedule_seat';

    protected $fillable = [
        'id',
        'seat_id',
        'work_schedule_id',
        'shift',
    ];

    public $timestamps = false;
}
