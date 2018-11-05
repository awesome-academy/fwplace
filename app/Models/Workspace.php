<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{

    protected $fillable = [
        'name',
        'image',
        'total_seat',
        'seat_per_row',
    ];

    protected $guarded = ['id'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function getPhotoAttribute()
    {
        return asset(config('site.workspace.display-image') . $this->image);
    }

    public function workSchedules()
    {
        return $this->hasManyThrough(WorkSchedule::class, User::class);
    }

    public function seats()
    {
        return $this->hasManyThrough(Seat::class, Location::class);
    }

    public function delete()
    {
        if ($this->users()->count() > 0) {
            return false;
        }
        $this->locations()->delete();

        return parent::delete();
    }

    public function getTotalUserAttribute()
    {
        $total = $this->users()->count();

        return $total;
    }
}
