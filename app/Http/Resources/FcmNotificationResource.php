<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FcmNotificationResource extends JsonResource
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
            'title' => __(notification_trans() . '.title.' . $this->action),
            'text' => __(notification_trans() . '.' . $this->action),
            'action' => $this->action,
            'action_id' => $this->action_id,
            'seen' => $this->seen,
            'created_at' => $this->created_at,
        ];
    }
}
