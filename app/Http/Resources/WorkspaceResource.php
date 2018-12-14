<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkspaceResource extends JsonResource
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
            'name' => $this->name,
            'image' => strlen($this->image) > 0 ? Storage::url('workspace/' . $this->image): '',
            'seat_per_column' => $this->seat_per_column,
            'seat_per_row' => $this->seat_per_row,
        ];
    }
}
