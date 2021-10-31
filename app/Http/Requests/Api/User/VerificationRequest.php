<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class VerificationRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'phone' => 'required|digits_between:8,10',
            'grant_type' => 'required|in:password,social',
            'provider' => 'required_if:grant_type,social',
            'access_token' => 'required_if:grant_type,social',
        ];
    }
}
