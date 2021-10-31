<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SimpleVerseSubResource extends JsonResource
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
             'number' => $this->number,
             'image' => $this->image,
             'parent_id' => $this->parent_id,
             'text' => $this->text,
             'childes' => SimpleVerseSubResource::collection($this->childes),
         ];
     }
}
