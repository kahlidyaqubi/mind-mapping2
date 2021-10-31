<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->phone,
            'age' => $this->age,
            'gender' => $this->gender,
            'country' => $this->country?new CountryResource($this->country):null,
            'memorization_level' => $this->memorization_level,
            'birth_date'=>$this->birth_date,
            'sound_on'=>$this->sound_on,
            'alert_on'=>$this->alert_on,
            'repeat_num'=>$this->repeat_num,
            'reciter' => $this->reciter ? new SimpleReciterResource($this->reciter) : null,
        ];
    }
}
