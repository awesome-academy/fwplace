<?php

namespace App\Models;

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
        return $this->belongsToMany(User::class)
            ->withPivot('id', 'registration_date', 'shift');
    }

    public function getSeatStatus($day)
    {
        $seatStatus = [];
        switch (count($this->users()->wherePivot('registration_date', $day)->get())) {
            case 1:
                if ($this->users()
                    ->wherePivot('registration_date', $day)
                    ->wherePivot('shift', config('site.shift.all'))
                    ->exists()
                ) {
                    $seatStatus += ['use' => __('All day')];
                } elseif ($this->users()
                    ->wherePivot('registration_date', $day)
                    ->wherePivot('shift', config('site.shift.morning'))
                    ->exists()
                ) {
                    $seatStatus += ['use' => __('Morning')];
                } elseif ($this->users()
                    ->wherePivot('registration_date', $day)
                    ->wherePivot('shift', config('site.shift.afternoon'))
                    ->exists()
                ) {
                    $seatStatus += ['use' => __('Afternoon')];
                }
                break;
            case 2:
                $seatStatus += ['use' => __('All day')];
                break;
            default:
                $seatStatus += ['use' => __('None')];
        }

        return $seatStatus;
    }

    public function checkSeatByUser($day, $userId)
    {
        return $this->users()
            ->wherePivot('user_id', $userId)
            ->wherePivot('registration_date', $day)
            ->exists();
    }
}
