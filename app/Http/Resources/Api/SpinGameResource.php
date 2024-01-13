<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SpinGameResource extends JsonResource
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
            'status' => $this->status,
            'spins' => auth()->user()->spins,
            'country_id' => $this->country_id,
            'country' => $this->country->country,
            'digit_one' =>  is_numeric($this->digit_one) ? (int)($this->digit_one) :$this->digit_one ,
            'digit_two' => is_numeric($this->digit_two) ? (int)($this->digit_two) :$this->digit_two,
            'digit_three' => is_numeric($this->digit_three) ? (int)($this->digit_three) :$this->digit_three,
            'digit_four' => is_numeric($this->digit_four) ? (int)($this->digit_four) :$this->digit_four,
            'digit_five' => is_numeric($this->digit_five) ? (int)($this->digit_five) :$this->digit_five,
            'digit_six' => is_numeric($this->digit_six) ? (int)($this->digit_six) :$this->digit_six,
            'digit_seven' => is_numeric($this->digit_seven) ? (int)($this->digit_seven) :$this->digit_seven,
            'digit_eight' => is_numeric($this->digit_eight) ? (int)($this->digit_eight) :$this->digit_eight,
            'digit_nine' => is_numeric($this->digit_nine) ? (int)($this->digit_nine) :$this->digit_nine,
        ];
    }
}
