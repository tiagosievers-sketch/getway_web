<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;

class RidpService
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
     * Initiate the RIDP request
     *
     * @param array $ridpData
     * @return array
     * @throws Exception
     */
    public function initiateRidp(array $ridpData): array
    {
        try {
            $response = $this->client->post('RIDPCrossCoreService', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                    'Content-Type' => 'application/json',
                    'message-id' => $this->generateMessageId(),
                ],
                'json' => $ridpData,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            throw new Exception("Error initiating RIDP request: " . $e->getMessage());
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
