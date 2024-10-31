<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\BookSalonStepFourValidation;
use App\Http\Requests\Api\User\BookSalonStepOneValidation;
use App\Http\Requests\Api\User\BookSalonStepThreeValidation;
use App\Http\Requests\Api\User\BookSalonStepTwoValidation;
use App\Http\Requests\Api\User\BookSalonValidation;
use App\Http\Requests\Api\User\ServicesArrayValidation;
use App\Http\Resources\Api\ExpertResource;
use App\Http\Resources\Api\SalonTimesResource;
use App\Http\Resources\Api\MainServiceWithExpertsResource;
use App\Http\Resources\Api\SalonBookingResource;
use App\Http\Resources\Api\SalonBranchResource;
use App\Http\Resources\Api\SalonBranchServicesResource;
use App\Http\Resources\Api\SalonResource;
use App\Http\Resources\Api\ServicesExpertsResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Expert;
use App\Models\Salon;
use App\Models\SalonBooking;
use App\Models\SalonBookingDetails;
use App\Models\SalonBranch;
use App\Models\SalonBranchService;
use App\Models\SalonBranchServiceExpert;
use App\Models\SalonTime;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalonController extends Controller
{

    use ApiResponseTrait;

    public function getSalons(){
        $salons = Salon::where('country_id', auth()->user()->country_id)->get();
        return $this->sendResponse(SalonResource::collection($salons));
    }
    public function getBranches(Salon $salon){
        $salon->load('branches');
        return $this->sendResponse(SalonBranchResource::collection($salon->branches));
    }
    public function getBranchServices(SalonBranch $salonBranch){
        $salonBranch->load('mainservices.children');
        return $this->sendResponse(SalonBranchServicesResource::collection($salonBranch->mainservices));
    }

    public function getServicesExperts(ServicesArrayValidation $request){
        $data = $request->validated();
        $serviceIds = $data['service_ids'];
        $services = SalonBranchService::with('experts','parent')->whereIn('id', $serviceIds)->get();
        if(isset($data['reservation_date'])){
            $services->map(function ($service) use ($data) {
                $service->reservation_date = $data['reservation_date']; // or set any specific date
                return $service;
            });
        }
        dd('fdf');
        return $this->sendResponse(ServicesExpertsResource::collection($services));
    }


    public function book(BookSalonValidation $request){
        $data = $request->validated();
        $branch = SalonBranch::with('salon')->findorfail($data['branch_id']);
        $booking = SalonBooking::create([
            'salon_id' => $branch->salon_id,
            'salon_branch_id' => $data['branch_id'],
            'user_id' =>auth()->user()->id,
            'day' => $data['day'],
        ]);
        foreach($data['service_ids'] as $service){
            SalonBookingDetails::create([
                'salon_id' => $branch->salon_id,
                'salon_branch_id' => $data['branch_id'],
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
