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



    //STK Push
    public function addPayment($params  = []){
        $pdo = New PDO("mysql:dbhost=127.0.0.1;dbname=ffos_db","root","");	
    
        try {
    
            $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    
            $paymentType = 'mpesa';
    
            $saveorder = $pdo->prepare("INSERT INTO payments
                                        (
                                            `order_id`,
                                            `order_ref`,
                                            `amnt_paid`,
                                            `amount`,
                                            `processed_by`,
                                            `payment_method`,
                                            `trans_id`
                                            ) 
                                            VALUES(?,?,?,?,?,?,?)");
            
            $saveorder -> bindValue(1,$params['orderID']);
            $saveorder -> bindValue(2,$params['orderID']);
            $saveorder -> bindValue(3,$params['Amount']);
            $saveorder -> bindValue(4,$params['Amount']);
            $saveorder -> bindValue(5,$params['PhoneNumber']);
            $saveorder -> bindValue(6,$paymentType);
            $saveorder -> bindValue(7,$params['MpesaReceiptNumber']);
    
            if($saveorder -> execute()){
                //Added to transactions
                return true;
            }else{
                die(print_r($saveorder->errorInfo()));
            }
        
            
        } catch (PDOException $e) {
    
            echo $e->getMessage();
            
        }
    }
    
    public function addTransaction($orderID, $amount = 0){

        $pdo = New PDO("mysql:dbhost=127.0.0.1;dbname=ffos_db","root","");	
    
        try {
    
            $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    
            $checkIfExists = $pdo->prepare("SELECT COUNT(*) FROM tbltransactions WHERE order_id = ? AND amount = ?");
            $checkIfExists->execute([$orderID, $amount]);
            $count = $checkIfExists->fetchColumn();
    
            if ($count == 0) {
    
                $saveorder = $pdo->prepare("INSERT INTO tbltransactions (order_id, amount) VALUES (?, ?)");
    
                
                $saveorder -> bindValue(1,$orderID);
                $saveorder -> bindValue(2,$amount);
    
                if($saveorder -> execute()){
                    //Added to transactions
    
                }else{
                    die(print_r($saveorder->errorInfo()));
                }
            }
        
            
        } catch (PDOException $e) {
    
            echo $e->getMessage();
            
        }
    }

}