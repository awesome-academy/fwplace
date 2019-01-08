<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $guarded = ['id'];

    public function workspace()
    {
        return $this->belongsTo('App\Models\Workspace');
    }

    public function program()
    {
        return $this->belongsTo('App\Models\Program');
    }

    public function position()
    {
        return $this->belongsTo('App\Models\Position');
    }

    public function subjects()
    {
        return $this->belongsToMany('App\Models\Subject');
    }

    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
}
