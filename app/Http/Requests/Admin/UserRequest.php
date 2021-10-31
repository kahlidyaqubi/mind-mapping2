<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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

        $id = request()->route('id');
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id . ',id,deleted_at,NULL',
            'password' => 'nullable|min:6',
            'phone' => 'nullable|numeric',
            'memorization_level' => 'nullable|in:keeper,new',
            'age' => 'nullable|numeric',
        ];


        return $rules;

    }
}
