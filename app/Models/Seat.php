<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = [
        'name',
        'location_id',
        'user_id',
    ];
    public $timestamps = false;

    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'location_id');
    }
}
