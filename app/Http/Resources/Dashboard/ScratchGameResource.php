<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ScratchGameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = auth()->user();
        $user = $user->load('country');
        return [
                'id' => $this->id,
                'code' => $this->code,
                'todaysDiscount' => $this->discount,
                'date' => $this->date,
                'currentDiscount' => json_decode(setting('scratch_discount'),true)[$user->country->country],
        ];
    }
}
