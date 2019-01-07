<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
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
        $rules = [
            'name' => 'required|min:3|max:255',
            'email' => 'required|unique:users,email,' . $this->id,
            'password' => 'required|string|min:6',
            'password_confirm' => 'required|string|min:6|same:password',
        ];
        if ($this->id) {
            $rules = [
                'name' => 'required|min:3|max:255',
                'email' => 'required|unique:users,email,' . $this->id,
            ];
        }

        return $rules;
    }
}
