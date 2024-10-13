<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CreateShipmentValidation;
use App\Http\Requests\Dashboard\TrackShipmentValidation;
use App\Http\Traits\ApiResponseTrait;
use App\Services\SMSAService\SMSAService;
use Illuminate\Http\Request;
use Exception;
use SoapClient;
use SoapFault;
use SoapHeader;
// define('SOAP_1_1', 1);


class ShipmentController extends Controller
{
    protected $smsaService;

    use ApiResponseTrait;
    public function __construct(SMSAService $smsaService)
    {
        $this->smsaService = $smsaService;
    }

    public function createShipment(CreateShipmentValidation $request)
    {
        $data = $request->validated();
        try {
            // Call the SMSA API through the service
            $response = $this->smsaService->addShipment($data);
            // Return the response (or you can handle it differently)
            return $this->sendResponse(['awbNo' => $response->addShipmentResult ]);

        } catch (Exception $e) {
            // Handle errors
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function trackShipment(TrackShipmentValidation $request){
        $data = $request->validated();
        try {
            // Call the SMSA API through the service
            $response = $this->smsaService->trackShipment($data);
            // Return the response (or you can handle it differently)
            return $this->sendResponse($response->getTrackResult->TrackDetailsList);

        } catch (Exception $e) {
            // Handle errors
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }




}
