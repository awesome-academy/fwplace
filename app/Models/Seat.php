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
        return $this->belongsTo('App\Models\Location', 'location_id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'seat_id', 'id');
    }
}
