<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Workspace extends Model
{
    protected $fillable = [
        'name',
        'image',
        'seat_per_column',
        'seat_per_row',
    ];

    protected $guarded = ['id'];

    public function users()
    {
        return $this->hasMany('App\Models\User', 'workspace_id');
    }

    public function locations()
    {
        return $this->hasMany('App\Models\Location', 'workspace_id');
    }

    public function getPhotoAttribute()
    {
        return asset(config('site.workspace.display-image') . $this->image);
    }

    public function workSchedules()
    {
        return $this->hasManyThrough('App\Models\WorkSchedule', 'App\Models\User');
    }

    public function batches()
    {
        return $this->belongsTo('App\Batch');
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
