<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = [
        'stop_day',
        'start_day',
        'position_id',
        'program_id',
        'workspace_id',
        'batch',
    ];

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

    public function getName()
    {
        return $this->workspace->name . ' - '
            . $this->program->name . ' - '
            . $this->position->name . ' - '
            . $this->batch;
    }
}
