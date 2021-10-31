<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class PartResource extends JsonResource
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
            'parent_id' => $this->parent_id,
            'image' => $this->image,
            'video' => $this->video,
            'video2' => $this->video2,
            'form_verse' => $this->form_verse,
            'to_verse' => $this->to_verse,
            'surah' => new SimpleSurahResource($this->surah),
            'verses' => SimpleVerseResource::collection($this->verses),
            'childes' => SimplePartResource::collection($this->childes),
        ];
    }
}
