<?php

namespace App\Services\SMSAService;

use App\Http\Traits\ApiResponseTrait;
use SoapClient;
use Exception;

class SMSAService
{
    protected $wsdl;
    protected $soapClient;


    public function __construct()
    {
        // Define the WSDL endpoint for SMSA Express
        $this->wsdl = 'http://track.smsaexpress.com/SECOM/SMSAwebServiceIntl.asmx?WSDL';
        try {
            // Initialize the SoapClient with the WSDL URL
            $this->soapClient = new SoapClient($this->wsdl);
        } catch (Exception $e) {
            throw new Exception('Unable to create SoapClient: ' . $e->getMessage());
        }
    }

    /**
     * Function to send a shipment request to SMSA Express
     */
    public function addShipment($data)
    {
        // Set the parameters for the SOAP request
            $params = [
                'passKey'    => $data['passKey'],
                'refNo'      => $data['refNo'],
                'sentDate'   => $data['sentDate'],
                'idNo'       => $data['idNo'],
                'cName'      => $data['cName'],
                'cntry'      => $data['cntry'],
                'cCity'      => $data['cCity'],
                'cZip'       => $data['cZip'],
                'cPOBox'     => $data['cPOBox'],
                'cMobile'    => $data['cMobile'],
                'cTel1'      => $data['cTel1'],
                'cTel2'      => $data['cTel2'],
                'cAddr1'     => $data['cAddr1'],
                'cAddr2'     => $data['cAddr2'],
                'shipType'   => $data['shipType'],
                'PCs'        => $data['PCs'],
                'cEmail'     => $data['cEmail'],
                'carrValue'  => $data['carrValue'],
                'carrCurr'   => $data['carrCurr'],
                'codAmt'     => $data['codAmt'],
                'weight'     => $data['weight'],
                'custVal'    => $data['custVal'],
                'custCurr'   => $data['custCurr'],
                'insrAmt'    => $data['insrAmt'],
                'insrCurr'   => $data['insrCurr'],
                'itemDesc'   => $data['itemDesc'],
                'vatValue'   => $data['vatValue'],
                'harmCode'   => $data['harmCode'],
            ];
        try {
            // Call the addShipment method on the SMSA API
            $response = $this->soapClient->__soapCall('addShipment', [$params]);
            // Return the result
            return $response;
        } catch (Exception $e) {
            // Handle any exceptions/errors
            throw new Exception('SOAP Request Failed: ' . $e->getMessage());
        }
    }

    public function trackShipment($data)
    {
        //Set the parameters for the SOAP request
            $params = [
                'passkey'    => $data['passkey'],
                'awbNo'      => $data['awbNo'],
            ];
        try {
            // Call the addShipment method on the SMSA API
            $response = $this->soapClient->__soapCall('getTrack', [$params]);
            // Return the result
            return $response;
        } catch (Exception $e) {
            // Handle any exceptions/errors
            throw new Exception('SOAP Request Failed: ' . $e->getMessage());
        }
    }



}
