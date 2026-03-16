<?php

namespace App\Actions\Hub;

use GuzzleHttp\Client;
use Exception;

class ApplicationActions
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
     * Create a new application
     *
     * @param array $applicationData
     * @return array
     * @throws Exception
     */
    public function createApplication(array $applicationData): array
    {
        try {
            $response = $this->client->post('ses/v1/applications', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => $applicationData,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            throw new Exception("Error creating application: " . $e->getMessage());
        }
    }

    /**
     * Retrieve an existing application
     *
     * @param string $applicationId
     * @return array
     * @throws Exception
     */
    public function getApplication(string $applicationId): array
    {
        try {
            $response = $this->client->get("ses/v1/applications/{$applicationId}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                    'Content-Type' => 'application/json',
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            throw new Exception("Error retrieving application: " . $e->getMessage());
        }
    }

    /**
     * Update an existing application
     *
     * @param string $applicationId
     * @param array $applicationData
     * @return array
     * @throws Exception
     */
    public function updateApplication(string $applicationId, array $applicationData): array
    {
        try {
            $response = $this->client->put("ses/v1/applications/{$applicationId}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => $applicationData,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            throw new Exception("Error updating application: " . $e->getMessage());
        }
    }

    /**
     * Submit an application for processing
     *
     * @param string $applicationId
     * @return array
     * @throws Exception
     */
    public function submitApplication(string $applicationId): array
    {
        try {
            $response = $this->client->post("ses/v1/applications/{$applicationId}/submissions", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                    'Content-Type' => 'application/json',
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            throw new Exception("Error submitting application: " . $e->getMessage());
        }
    }

    /**
     * Delete an application
     *
     * @param string $applicationId
     * @return array
     * @throws Exception
     */
    public function deleteApplication(string $applicationId): array
    {
        try {
            $response = $this->client->delete("ses/v1/applications/{$applicationId}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                    'Content-Type' => 'application/json',
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            throw new Exception("Error deleting application: " . $e->getMessage());
        }
    }
}
