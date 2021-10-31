<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SimpleVerseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
     {
         return [
             'id' => $this->id,
             'text' => $this->text,
             'number' => $this->number,
             'subs' => SimpleVerseSubResource::collection($this->verse_subs->whereNull('parent_id')),
         ];
     }
}
