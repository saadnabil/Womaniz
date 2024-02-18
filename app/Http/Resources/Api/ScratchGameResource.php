<?php

namespace App\Http\Resources\Api;

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
        return [
            'id' => $this->id,
            'code' => $this->scratchgame->code,
            'date'=> $this->date,
            'expiration_date' => $this->expiration_date,
            'open_cell_index' => $this->open_cell_index,
            'time_open_cell_index' => $this->time_open_cell_index,
            'allow_to_scratch' => $this->open_cell_index == 0 ? 1 : (Carbon::now(auth()->user()->country->timezone)->diffInMinutes(Carbon::createFromFormat('h:i a',$this->time_open_cell_index)) > 60 ? 1 : 0) ,
            'cell_one_status' =>  $this->open_cell_index >= 1 ? 1 : 0,
            'cell_two_status' => $this->open_cell_index >= 2 ? 1 : 0,
            'cell_three_status' => $this->open_cell_index >= 3 ? 1 : 0,
            'cell_four_status' => $this->open_cell_index >= 4 ? 1 : 0,
            'cell_five_status' => $this->open_cell_index >=  5? 1 : 0,


        ];
    }
}
