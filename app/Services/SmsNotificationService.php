<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class SmsNotificationService
{
    protected $client;
    protected $apiUrl;
    protected $apiToken;

    public function __construct()
    {
        $this->client = new Client();

        $this->apiUrl = env('PHILSMS_API_URL', 'https://app.philsms.com/api/v3/sms/send');

        $this->apiToken = env('PHILSMS_API_TOKEN');
    }

    public function sendSms(string $number, string $message, string $senderId = 'PhilSMS'): bool
    {
        $data = [
            'recipient' => $number,
            'sender_id' => $senderId,
            'type' => 'plain',
            'message' => $message,
        ];

        try {
            $response = $this->client->post($this->apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiToken,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => $data,
            ]);

            $responseBody = $response->getBody()->getContents();
            $responseData = json_decode($responseBody, true);

            if (isset($responseData['success']) && $responseData['success'] === true) {
                Log::info("SMS sent successfully to {$number}: {$message}");
                return true;
            } else {
                Log::error("SMS sending failed: " . ($responseData['message'] ?? 'Unknown error'));
                return false;
            }
        } catch (RequestException $e) {
            $errorMessage = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            Log::error("SMS sending failed: {$errorMessage}");
            return false;
        }
    }

}
