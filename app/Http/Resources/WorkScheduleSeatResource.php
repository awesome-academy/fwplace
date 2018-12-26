<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class WorkScheduleSeatResource extends JsonResource
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
            'date' => $this->date,
            'id' => $this->id,
            'shift' => $this->shift,
            'morningSeats' => $this->morningSeats,
            'afternoonSeats' => $this->afternoonSeats,
        ];
    }
}
