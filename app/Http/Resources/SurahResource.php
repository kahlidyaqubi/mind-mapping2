<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SurahResource extends JsonResource
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
            'name' => $this->name,
            'verse_count' => $this->verse_count,
            'type' => $this->type,
            'page' => $this->page_number,
            'another_name' => $this->another_name,
            'has_many_part' => ($this->parts->first() && $this->parts->count() > 1) ? 1 : 0,
            'maps' => SimplePartResource::collection($this->parts->whereNull('parent_id')),
        ];
    }
}
