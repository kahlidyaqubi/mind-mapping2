<?php

namespace App\Http\Requests\Api\User;


use App\Rules\CheckOldPasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email' => 'nullable|email|unique:users,email,' . auth()->user()->id . ',id,deleted_at,NULL',
            'old_password' => ['nullable', new CheckOldPasswordRule()],
            'password' => 'nullable|min:6|confirmed',
            'birth_date' => 'nullable|date|date_format:Y-m-d',
            'gender' => 'nullable|in:male,female',
            'memorization_level' => 'nullable|in:keeper,new',
            'reciter_id' => 'nullable|exists:reciters,id',
            'repeat_num' => 'nullable|numeric',
            'alert_on' => 'nullable|numeric|digits_between:0,1',
            'sound_on' => 'nullable|numeric|digits_between:0,1',
        ];

        return $rules;
    }
}
