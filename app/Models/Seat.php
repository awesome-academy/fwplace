<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = [
        'name',
        'location_id',
    ];
    public $timestamps = false;

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('id', 'registration_date', 'is_full_day');
    }

    public function checkUsedSeat($date, $shift)
    {
        switch ($shift) {
            case config('site.shift.all'):
                return $this->users()->wherePivot('registration_date', $date)
                    ->wherePivotIn('shift', [$shift, config('site.shift.morning'), config('site.shift.afternoon')])
                    ->exists();
            case config('site.shift.morning'):
                return $this->users()->wherePivot('registration_date', $date)
                    ->wherePivotIn('shift', [config('site.shift.all'), $shift])
                    ->exists();
            case config('site.shift.afternoon'):
                return $this->users()->wherePivot('registration_date', $date)
                    ->wherePivotIn('shift', [config('site.shift.all'), $shift])
                    ->exists();
            default:
                return false;
        }
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'seat_id', 'id');
    }
}
