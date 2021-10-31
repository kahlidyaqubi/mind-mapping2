<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
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
            //
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|min:6',
            'phone' => 'nullable|numeric',
            'memorization_level' => 'nullable|in:keeper,new',
            'reciter_id' => 'nullable|exist:reciters,id',
            'birth_date' => 'nullable|date|date_format:Y-m-d',
        ];
    }
}
