<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;

class FarsService
{
    protected $client;
    protected $accessToken;

    public function __construct($accessToken)
    {
        $this->client = new Client([
            'base_uri' => env("HUB_BASE_URL"),
        ]);        
        $this->accessToken = $accessToken;
    }

    /**
     * Submit a fraud report to FARS
     *
     * @param array $farsData
     * @return array
     * @throws Exception
     */
    public function submitFraudReport(array $farsData): array
    {
        try {
            $response = $this->client->post('FARSServiceRest', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                    'Content-Type' => 'application/json',
                    'message-id' => $this->generateMessageId(),
                ],
                'json' => $farsData,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            throw new Exception("Error submitting fraud report: " . $e->getMessage());
        }
    }

    /**
     * Generate a unique message ID
     *
     * @return string
     */
    protected function generateMessageId(): string
    {
        return uniqid('', true);
    }
}
