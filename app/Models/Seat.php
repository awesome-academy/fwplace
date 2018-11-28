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
}
