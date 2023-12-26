<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class SalonTimesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'day' => $this->day,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'salon_id' => $this->salon_id,
            'day_calendar_index' => get_day_calendar_index()[$this->day],
        ];
    }
}
