<?php

namespace App\Http\Resources;

use App\Models\Role;
use App\Models\Batch;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $url;
        if ($this->avatar != null) {
            if (Storage::exists($this->avatar)) {
                $url = Storage::url($this->avatar);
            } else {
                $url = config('api.default.avatar');
            }
        } else {
            $url = config('api.default.avatar');
        }
        
        $data = [
            'id' => $this->id,
            'avatar' => $url,
            'name' => $this->name,
            'email' => $this->email,
            'school' => $this->school,
            'role' => Role::findOrFail($this->role)->display_name,
        ];
        if ($this->batch_id) {
            $batch = Batch::findOrFail($this->batch_id);
            $data = array_merge($data, [
                'batch_id' => $this->batch_id,
                'batch' => $this->nameBatch($batch),
            ]);
        }

        return $data;
    }

    public function nameBatch($batch)
    {
        return $this->workspace->name . '-'
            . $this->program->name . '-'
            . $this->position->shorthand . '-'
            . $batch->batch;
    }
}
