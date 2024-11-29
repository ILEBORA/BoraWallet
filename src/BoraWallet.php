<?php
/**
 * BoraWallet
 * Author: Dominic Karau (api.boracore.co.ke)
 * Description: Package for Accessing BoraWallet API services.
 * License: MIT
 */
namespace ILEBORA;

use ILEBORA\Services\BoraService;

class BoraWallet extends BoraService
{

    private $phone;
    private $amount;
    private $orderID;

    public function setPhone($phone) {
        $this->phone = $phone;
        return $this;
    }

    public function setAmount($amount = 100){
        $this->amount = $amount;
        return $this;
    }

    public function setOrderID($orderID = ''){
        $this->orderID = $orderID;
        return $this;
    }

    public function getCheckoutForm(){    
        $url = $this->apiUrl . '/' . $this->apiVersion . '/wallet/payment/mpesa/stkpush/gethtml';
                
        $headers = [
            'Content-Type:application/json',
            'Authorization: Bearer '. base64_encode(BoraConstants::userID.":".BoraConstants::apiKey)
        ];
        
        $payload = array(//Fill in the request parameters with valid values
                'displayName' => $this->displayName,
                'userID'      => $this->userID,
                'apiKey'      => $this->apiKey,
                'phone'     => $this->phone,
                'amount'    => $this->amount,
                'orderID'   => $this->orderID,
                'backLink'  => $this->backLink,
                'onSuccess'  => $this->onSuccess,
                'onFailure'  => $this->onFailure,
                'shortCode' => 'B', //TODO:: enter own
            );

        $response = $this->makeRequest($url, $payload, $headers);

        return json_encode($response); 

    }


    public function getBalance(){
        //TODO:: add balance route
    }

    public function getWithdrawalForm(){
        //TODO:: add withdrawal form
    }

}