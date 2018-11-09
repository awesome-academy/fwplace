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
        'name',
        'diagram',
        'content',
    ];

    public function getDesignDiagramAttribute()
    {
        if ($this->diagram) {
            return asset(config('site.diagram.display-image') . $this->diagram);
        }

        return asset(config('site.default-image'));
    }
}
