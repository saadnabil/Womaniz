<?php

namespace App\Http\Resources\Api;

use App\Models\SalonBranchExpertTime;
use App\Models\SalonBranchService;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicesExpertsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $expertsArray = [];


        foreach($this->experts as $expert){

            $day = Carbon::parse($this->reservation_date)->format('l');
            $timeSlots = [];
            $expertTime = SalonBranchExpertTime::where([
                'day' => $day,
                'salon_branch_id' => $this->salon_branch_id,
                'expert_id' => $expert->id,
            ])->first();

            $serviceDuration = $this->duration;
            if($expertTime){
                $timeSlots =  generateTimeSlotsBetweenIntervals($expertTime->start_time, $expertTime->end_time, $serviceDuration);
            }

            $expertsArray[] = [
                'id' => $expert->id,
                'name' => $expert->name,
                'slots' => $timeSlots,
            ];
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'duration' => $this->duration. ' hr',
            'reservation_date' => $this->reservation_date,
            'parent' => [
                'id' => $this->parent->id,
                'name' => $this->parent->name,
            ],
            'experts' => $expertsArray
        ];
    }
}
