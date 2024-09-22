<?php
namespace App\Services\SMSAService;
use Illuminate\Support\Facades\Http;


class SMSAService{
    protected $baseUrl;
    protected $apiKey;
    public function __construct()
    {
        $this->baseUrl = 'https://track.smsaexpress.com/SeCom/SMSAwebService.asmx'; // Example base URL, adjust accordingly
        $this->apiKey = ''; // Store your API key in the services config file
    }
    public function createShipment(array $shipmentData)
    {
        //$passKey => Unique Code for each Customer provided by SMSA
        //$refNo => Unique Number  for each day
        //$sentDate => date
        //$idNo => Optional
        //$cName  => Cannot be Null
        //$cntry => Country KSA ,
        //$cCity => Destination City Name ,
        //$cZip => Optional Zip Code
        //$cPOBox => Optional PO Box
        //$cMobile => number Must be at least 9 digits
        //$cTel1 => optional
        //$cTel2 => optional
        //$cAddr1 => client address mandatory
        //$cAddr2 => optional
        //$shipType => DLV for normal Shipments for other special cases we will provide | Mandatory Value from DLV,VAL,HAL or BLT  ,
        //$PCs => No. of Pieces required number
        //$cEmail => Optional
        //$carrValue => Integer Optional Carriage Value
        //$carrCurr => string Carriage Currency optional
        //$codAmt => Required if CASH ON DELIVERY Value Either 0 or greater than 0 in case of COD
        //$weight => Weight of the Shipment string
        //$custVal => Customs Value Optional String
        //$custCurr => Customs Currency Optional
        //$insrAmt => Insurance Value
        //$insrCurr => Insurance Currency optional
        //$itemDesc => Description of the items present in shipment optional,
        //$vatValue => VAT Value of the shipment required,
        //$harmCode => Harmonized Code for Items in shipment
        $response = Http::post($this->baseUrl . '/createShipment', array_merge($shipmentData, [
            'passKey' => $this->apiKey,
        ]));
        return $response->json();
    }



    public function trackShipment($awbNumber)
    {
        $response = Http::get($this->baseUrl . '/getTracking', [
            'awbNo' => $awbNumber,
            'passKey' => $this->apiKey,
        ]);

        return $response->json();
    }


    Public function getTracking($awbNo,$passKey){
        // $awbNo  => Shipment Tracking Number
        //$passKey => PassKey Provided for secure access




        /* The output is object of Dataset with tracking details of the requested awbNo.
        It returns three columns as awbno, “DateTime” of the Event, Activity/Scan and Details. */
    }

    Public Function addShip($data){
        //with shipper and delivery information
        //$sName => Shipper Name required
        //$sContact => Shipper Contact name required required
        //$sAddr1 => Shipper Address required ,
        //$sAddr2 => Shipper Address optional ,
        //$sCity => Shipper City required ,
        //$sPhone => Shipper Phone number required,
        //$sCntry => Shipper country required,
        //$prefDelvDate => Preferred Delivery date in case of future or delayed delivery date Optional,
        //$gpsPoints => Google GPS points separated by comma for delivery to customer by Google maps ,
        /*The output is a String whether the shipment information Upload was Success or failed with reason.
        If the data upload to our system was successful it will return the SMSA Airway bill Number which has to be displayed on the shipment with barcode. */
    }
}
