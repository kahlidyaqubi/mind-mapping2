<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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

        if (request()->segment(3) == 'profile') {
            return [
                'name' => 'required|unique:admins,name,' . authAdmin()->id . ',id,deleted_at,NULL',
                'email' => 'required|email|unique:admins,email,' . authAdmin()->id . ',id,deleted_at,NULL',
                'password' => 'nullable|min:6'
            ];
        } elseif (request()->segment(2) == 'login') {

            return [
                'email' => 'required|string|email',
                'password' => 'required|string'
            ];
        } else {

            $id = request()->route('id');
            $rules = [
                'name' => 'required|unique:admins,name,' . request()->route('id') . ',id,deleted_at,NULL',
                'phone' => 'required',
                'email' => 'required|email|unique:admins,email,' . request()->route('id') . ',id,deleted_at,NULL',
                'type' => 'nullable|in:admin,super_admin',
            ];
            if (!isset($id)) {
                $rules[] = ['password' => 'nullable|min:6'];
            }
            return $rules;
        }
    }
}
