<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SimplePartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'name' => $this->name,
            'image' => $this->image,
            'form_verse' => $this->form_verse,
            'to_verse' => $this->to_verse,
            'childes' => SimplePartResource::collection($this->childes),
        ];
    }
}
