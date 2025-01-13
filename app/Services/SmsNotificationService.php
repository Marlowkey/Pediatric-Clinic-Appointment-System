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
        $this->apiToken = env('PHILSMS_API_TOKEN'); // Store the API token in your .env file
    }

    /**
     * Sends an SMS message using the PhilSMS API.
     *
     * @param string $number The recipient's phone number.
     * @param string $message The message to send.
     * @param string|null $senderId Optional sender ID (defaults to "YourName").
     * @return bool True if the message was sent successfully, false otherwise.
     */
    public function sendSms(string $number, string $message, string $senderId = 'Clarianes'): bool
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
                throw new \Exception($responseData['message'] ?? 'Unknown error');
            }
        } catch (RequestException $e) {
            $errorMessage = $e->hasResponse()
                ? $e->getResponse()->getBody()->getContents()
                : $e->getMessage();
            Log::error("SMS sending failed: {$errorMessage}");
            return false;
        }
    }
}
