<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\BookSalonStepFourValidation;
use App\Http\Requests\Api\User\BookSalonStepOneValidation;
use App\Http\Requests\Api\User\BookSalonStepThreeValidation;
use App\Http\Requests\Api\User\BookSalonStepTwoValidation;
use App\Http\Resources\Api\ExpertResource;
use App\Http\Resources\Api\SalonTimesResource;
use App\Http\Resources\Api\MainServiceWithExpertsResource;
use App\Http\Resources\Api\SalonBookingResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Expert;
use App\Models\SalonBooking;
use App\Models\SalonBookingDetails;
use App\Models\SalonBranchService;
use App\Models\SalonTime;
use Carbon\Carbon;
class SalonController extends Controller
{

    use ApiResponseTrait;

    public function bookStepOne(BookSalonStepOneValidation $request){
        $data = $request->validated();
        $branchId = $data['salon_branch_id'];
        $salonId = $data['salon_id'];
        $selectedSubServiceIds = collect($data['salon_branch_service'])->pluck('id')->unique()->values()->all();
        $parentServices = SalonBranchService::with(['experts' => function ($query) use ($branchId , $salonId) {
            // Additional condition to filter experts by branch ID
            $query->whereHas('branches', function ($subquery) use ($branchId , $salonId){
                $subquery->where('salon_branches.id', $branchId)
                ->where('salon_branches.salon_id', $salonId);
            });
        }])
        ->where(function ($query) use ($selectedSubServiceIds) {
            $query->whereIn('id', $selectedSubServiceIds)
                ->orWhereNull('parent_id');
        })
        ->whereNull('parent_id')
        ->get();
        return $this->sendResponse(MainServiceWithExpertsResource::collection($parentServices ));
    }

    public function bookStepTwo(BookSalonStepTwoValidation $request){
        $data = $request->validated();
        $salonTimes = SalonTime::where([ 'salon_id' => $data['salon_id'] ])->get();
        return $this->sendResponse(['work_days' => SalonTimesResource::collection($salonTimes)]);
    }

    public function bookStepThree(BookSalonStepThreeValidation $request){
        $data = $request->validated();
        $uniqueExpertsIds = collect($data['salon_branch_service'])->pluck('expert_id')->unique()->values()->all();
        $branchId = $data['salon_branch_id'];
        $salonId = $data['salon_id'];
        $experts = Expert::with(['times' => function($query) use($branchId , $salonId){
            $query->where('salon_id', $salonId)
                  ->where('salon_branch_id', $branchId);
        }])->whereIn('id', $uniqueExpertsIds)->get();
        $reservationDay = $data['day'];
        $reservationDayName = Carbon::parse($reservationDay)->format('l');
        foreach($experts as $expert){
            $time = $expert->times->where('day', $reservationDayName)->first();
            if($time){
                $slots = generateTimeSlotsBetweenIntervals($time->start_time, $time->end_time);
                $expert->slots = $slots;
            }
        }
        return $this->sendResponse(ExpertResource::collection($experts));
    }

    public function bookStepFour(BookSalonStepFourValidation $request){
        $data = $request->validated();
        $booking = SalonBooking::create([
            'salon_id' => $data['salon_id'],
            'salon_branch_id' => $data['salon_branch_id'],
            'user_id' =>auth()->user()->id ,
            'day' => $data['day'],
        ]);
        foreach($data['salon_branch_service'] as $service){
            SalonBookingDetails::create([
                'salon_id' => $data['salon_id'],
                'salon_branch_id' => $data['salon_branch_id'],
                'user_id' =>auth()->user()->id,
                'day' => $data['day'],
                'time' => $service['time'],
                'expert_id' => $service['expert_id'],
                'salon_branch_service_id' => $service['id'],
                'salon_booking_id' =>  $booking->id,
            ]);
        }
        //get response data
        $bookingData = SalonBookingDetails::query()
            ->where('salon_booking_id', $booking->id)  // Filter by salon_booking_id = 1
            ->with([
                'expert',                // Eager load the related expert model
                'service',  // Eager load salon service and its nested service model
            ])
            ->get()
            ->groupBy('expert.id')  // Group results by expert
            ->map(function ($bookingsByExpert) {
                // Format data for each expert
                $expert = $bookingsByExpert->first()->expert;
                $bookings = $bookingsByExpert->map(function ($booking) {
                    $booking = $booking->load('service');
                    return [
                        'day' => $booking->day,
                        'time' => $booking->time,
                        'service' => $booking->service->name,  // Access service name
                        'price' => $booking->service->price,
                        'price_after_sale' => $booking->service->price_after_sale,
                        'discount' => $booking->service->discount,
                    ];
                });
            return [
                'expert' => $expert,
                'bookings' => $bookings,
            ];
        });
        //get response data
        return $this->sendResponse(SalonBookingResource::collection($bookingData));
        // return $this->sendResponse($bookingData);
    }
}
