<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\SMSAService\SMSAService;
use Illuminate\Http\Request;
use Exception;
use SoapClient;
use SoapFault;
use SoapHeader;
define('SOAP_1_1', 1);


class ShipmentController extends Controller
{
    protected $smsaService;

    // public function __construct(SMSAService $smsaService)
    // {
    //     $this->smsaService = $smsaService;
    // }

    // public function createShipment(Request $request)
    // {
    //     // You can validate the request here (optional)
    //     $validated = $request->validate([
    //         'passKey'    => 'required|string',
    //         'refNo'      => 'required|string',
    //         'sentDate'   => 'required|date',
    //         'idNo'       => 'required|string',
    //         'cName'      => 'required|string',
    //         'cntry'      => 'required|string',
    //         'cCity'      => 'required|string',
    //         'cZip'       => 'required|string',
    //         'cMobile'    => 'required|string',
    //         'shipType'   => 'required|string',
    //         'PCs'        => 'required|integer',
    //         'cEmail'     => 'required|email',
    //         'weight'     => 'required|numeric',
    //         'custVal'    => 'required|numeric',
    //         'itemDesc'   => 'required|string',
    //     ]);
    //     try {
    //         // Call the SMSA API through the service
    //         $response = $this->smsaService->addShipment($validated);
    //         // Return the response (or you can handle it differently)
    //         return response()->json($response, 200);
    //     } catch (Exception $e) {
    //         // Handle errors
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }

    public function createShipment(Request $request)
    {
        $url = "http://track.smsaexpress.com/SECOM/SMSAwebServiceIntl.asmx";
        $data = [
            'passKey' => 'Testing2',
            'refNo' => '123456',
            'sentDate' => '2024-10-01',
            'idNo' => '987654321',
            'cName' => 'John Doe',
            'cntry' => 'SA',
            'cCity' => 'Riyadh',
            'cZip' => '11564',
            'cMobile' => '+966500000000',
            'shipType' => 'VLF',
            'PCs' => 1,
            'cEmail' => 'john@example.com',
            'weight' => '5.0',
            'custVal' => '100',
            'itemDesc' => 'Books',
            // Add any other required shipment details here
        ];

        $options = [
            'uri' => 'http://track.smsaexpress.com/secom/SMSAWebserviceIntl',
            'soap_version' => SOAP_1_1,
            'trace' => true, // Enable trace for debugging (optional)
        ];

        try {
            $client = new SoapClient($url, $options);

            $headers = new SoapHeader(
                'http://schemas.xmlsoap.org/soap/envelope/',
                'SOAPAction',
                'http://track.smsaexpress.com/secom/SMSAWebserviceIntl/addShip'
            );

            $client->__setSoapHeaders($headers);

            $response = $client->__call('addShip', [$data]);

            if (isset($response['addShipResult'])) {
                return response()->json([
                    'message' => 'Shipment created successfully',
                    'tracking_number' => $response['addShipResult'], // Assuming response contains tracking number
                ]);
            } else {
                return response()->json(['message' => 'Error creating shipment'], 500);
            }
        } catch (SoapFault $exception) {
            return response()->json([
                'message' => 'SOAP Error: ' . $exception->getMessage(),
            ], 500);
        }
    }
}
