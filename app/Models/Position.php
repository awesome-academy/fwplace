<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'name',
        'is_fulltime',
        'allow_register',
    ];

    public function users()
    {
        return $this->hasMany('App\Models\User', 'position_id');
    }

    public function batches()
    {
        return $this->belongsTo('App\Batch');
    }
}
