<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VerseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    protected $reciter_id;

    public function __construct($resource, $reciter_id = null)
    {
        parent::__construct($resource);
        $this->reciter_id = $reciter_id;
    }

    public function toArray($request)
    {

        $reciter_id = ($this->reciter_id) ? $this->reciter_id : (session()->has('reciter_id') ? session()->get('reciter_id') : null);
        return [
            'id' => $this->id,
            'text' => $this->text,
            'surah' => new SimpleSurahResource($this->surah),
            'map' => new SimplePartResource($this->part()),
            'number' => $this->number,
            'subs' => SimpleVerseSubResource::collection($this->verse_subs->whereNull('parent_id')),
            'sounds' => SimpleVerseSoundResource::collection($this->sounds()->when($reciter_id, function ($q) use ($reciter_id) {
                $q->where('reciter_id', $reciter_id);
            })->get()),

        ];
    }
}
