<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignDiagram extends Model
{
    protected $table = 'design_diagram';

    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
        'content',
        'status',
        'workspace_id',
    ];

    public function getDesignDiagramAttribute()
    {
        if ($this->diagram) {
            return asset(config('site.diagram.display-image') . $this->diagram);
        }

        return asset(config('site.default-image'));
    }

    public function getDiagramContentAttribute()
    {
        if ($this->content != strip_tags($this->content)) {
            return $this->content;
        }

        return false;
    }
}
