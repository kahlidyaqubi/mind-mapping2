<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PartRequest extends FormRequest
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
            'surah_id' => 'required|numeric',
            'form_verse' => 'required|numeric|lte:to_verse',
            'to_verse' => 'required|numeric|gte:form_verse',
        ];
        return $rules;
    }
}
