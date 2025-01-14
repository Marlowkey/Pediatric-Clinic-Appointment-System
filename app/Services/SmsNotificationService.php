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
        // Initialize the Guzzle HTTP client
        $this->client = new Client();

        // Set the API URL (can be configured via environment variables)
        $this->apiUrl = env('PHILSMS_API_URL', 'https://app.philsms.com/api/v3/sms/send');

        // Get the API token from the environment file
        $this->apiToken = env('PHILSMS_API_TOKEN');
    }

    /**
     * Send SMS to a recipient
     *
     * @param string $number The recipient's phone number
     * @param string $message The message content
     * @param string $senderId The sender's ID (default is 'Clarianes')
     * @return bool True if SMS was sent successfully, false otherwise
     */
    public function sendSms(string $number, string $message, string $senderId = 'PhilSMS'): bool
    {
        // Prepare the request payload
        $data = [
            'recipient' => $number,
            'sender_id' => $senderId,
            'type' => 'plain', // You can change this to 'unicode' if needed
            'message' => $message,
        ];

        try {
            // Send the POST request to the API
            $response = $this->client->post($this->apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiToken,  // Add Bearer token in the Authorization header
                    'Content-Type' => 'application/json',  // Set content type as JSON
                    'Accept' => 'application/json',  // Set Accept header for JSON response
                ],
                'json' => $data,  // Attach JSON payload to the request
            ]);

            // Get the response body and decode it as an array
            $responseBody = $response->getBody()->getContents();
            $responseData = json_decode($responseBody, true);

            // Check if the response indicates success
            if (isset($responseData['success']) && $responseData['success'] === true) {
                Log::info("SMS sent successfully to {$number}: {$message}");
                return true;
            } else {
                // If the API response does not indicate success, throw an exception
                throw new \Exception($responseData['message'] ?? 'Unknown error');
            }
        } catch (RequestException $e) {
            // Capture and log any error that occurs during the request
            $errorMessage = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            Log::error("SMS sending failed: {$errorMessage}");
            return false;
        }
    }
}
