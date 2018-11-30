<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $guarded = ['id'];

    public function workspace()
    {
        return $this->belongsTo('App\Workspace');
    }

    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    public function type()
    {
        return $this->belongsTo('App\Type');
    }

    public function subjects()
    {
        return $this->belongsToMany('App\Subject');
    }

    public function months()
    {
        return $this->hasMany('App\Month');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
