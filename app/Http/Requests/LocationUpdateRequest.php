<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LocationUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'max:191',
                Rule::unique('locations')->where(function ($query) {
                    return $query->where('id', '!=', $this->id)->where('workspace_id', $this->workspace_id);
                }),
            ],
            'image' => 'image|nullable',
        ];
    }
}
