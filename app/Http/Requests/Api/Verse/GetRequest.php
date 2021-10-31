<?php

namespace App\Http\Requests\Api\Verse;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetRequest extends FormRequest
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
            'surah_id' => 'required_without_all:part_id,text',
            'part_id' => 'required_without_all:surah_id,text',
            'text' => 'required_without_all:surah_id,part_id',
            'reciter_id'=>'nullable|exist:reciters',
        ];
    }
}
