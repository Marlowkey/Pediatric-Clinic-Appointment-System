<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class SmsNotificationService
{
    protected $client;
    protected $twilioNumber;

    public function __construct()
    {

        $this->client = new Client(
            env('TWILIO_ACCOUNT_SID'), // Twilio Account SID
            env('TWILIO_AUTH_TOKEN')   // Twilio Auth Token
        );


        $this->twilioNumber = env('TWILIO_PHONE_NUMBER');
    }


    public function sendSms(string $number, string $message): bool
    {
        try {
            // Send SMS using Twilio
            $this->client->messages->create($number, [
                'from' => $this->twilioNumber,
                'body' => $message,
            ]);

            Log::info("SMS sent successfully to {$number}: {$message}");
            return true;
        } catch (\Exception $e) {
            Log::error('SMS sending failed: ' . $e->getMessage());
            return false;
        }
    }
}
