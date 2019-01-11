<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'start_day' => $this->start_day,
            'stop_day' => $this->stop_day,
            'batch' => $this->batch,
            'workspace' => $this->workspace->name,
            'team' => $this->program->name,
            'type' => $this->position->name,
            'name' => $this->nameBatch(),
            'subjects' => $this->subjects,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function nameBatch()
    {
        return $this->workspace->name . '-'
            . $this->program->name . '-'
            . $this->position->shorthand . '-'
            . $this->batch;
    }
}
