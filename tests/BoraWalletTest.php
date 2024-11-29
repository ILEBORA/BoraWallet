<?php

use ILEBORA\BoraWallet;
use PHPUnit\Framework\TestCase;

class BoraWalletTest extends TestCase
{
    public function testSetApiKey()
    {
        // Create an instance of the BoraSMS class
        $sms = new BoraWallet();
        
        // Set API Key using the setter method
        $sms->setApiKey('your_api_key');
        
        // Use reflection or getter to check if API key is set correctly (assuming a getter exists or directly testing behavior)
        $this->assertEquals('your_api_key', $sms->getApiKey());
    }

    public function testMissingCredentials()
    {
        // Expect an exception when credentials are missing
        $this->expectException(\Exception::class);
        
        $sms = new BoraSMS();
        $sms->sendSMS(); // This should fail due to missing credentials
    }
}
