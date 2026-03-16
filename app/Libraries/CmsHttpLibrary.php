<?php

namespace App\Libraries;


use Exception;
use GuzzleHttp\Client;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;


class CmsHttpLibrary
{
    //    config("cmsmarketplace.CMS_MARKETPLACE_TOKEN");
    //    config("cmsmarketplace.CMS_MARKETPLACE_BASE_URL");
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    /**
     * @throws Exception
     */
    public static function getStates(string $year = '')
    {
        $endpoint = 'states';
        $token = config("cmsmarketplace.CMS_MARKETPLACE_TOKEN");
        $url = config("cmsmarketplace.CMS_MARKETPLACE_BASE_URL") . $endpoint;
        $params = [
            'query' => [
                'apikey' => $token
            ]
        ];
        if ($year != '') {
            $params['query']['year'] = $year;
        }
        $client = new Client();
        try {
            $response = $client->request('GET', $url, $params);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            if ($statusCode >= 200 && $statusCode < 300) {
                return json_decode($body);
            } else {
                Log::error('Fail to get States: ' . $statusCode . ' - ' . $body);
                return false;
            }
        } catch (GuzzleException | Exception $e) {
            Log::error('Fail to get States: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public static function getState(string $abbrev, string $year = '')
    {
        $endpoint = 'states/' . $abbrev;
        $token = config("cmsmarketplace.CMS_MARKETPLACE_TOKEN");
        $url = config("cmsmarketplace.CMS_MARKETPLACE_BASE_URL") . $endpoint;
        $params = [
            'query' => [
                'apikey' => $token
            ]
        ];
        if ($year != '') {
            $params['query']['year'] = $year;
        }
        $client = new Client();
        try {
            $response = $client->request('GET', $url, $params);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            if ($statusCode >= 200 && $statusCode < 300) {
                return json_decode($body);
            } else {
                Log::error('Fail to get ' . $abbrev . ' State: ' . $statusCode . ' - ' . $body);
                return false;
            }
        } catch (GuzzleException | Exception $e) {
            Log::error('Fail to get ' . $abbrev . ' State: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public static function getCoverageSearch(string $query, string $zipcode)
    {
        $endpoint = 'coverage/search';
        $token = config("cmsmarketplace.CMS_MARKETPLACE_TOKEN");
        $url = config("cmsmarketplace.CMS_MARKETPLACE_BASE_URL") . $endpoint;
        $params = [
            'query' => [
                'apikey' => $token,
                'q' => $query,
                'zipcode' => $zipcode
            ]
        ];
        $client = new Client();
        try {
            $response = $client->request('GET', $url, $params);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            if ($statusCode >= 200 && $statusCode < 300) {
                return json_decode($body);
            } else {
                Log::error('Fail to get States: ' . $statusCode . ' - ' . $body);
                return false;
            }
        } catch (GuzzleException | Exception $e) {
            Log::error('Fail to get States: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public static function getProvidersSearch(string $query, string $zipcode, string $type, string $specialty = '')
    {
        $endpoint = 'providers/search';
        $token = config("cmsmarketplace.CMS_MARKETPLACE_TOKEN");
        $url = config("cmsmarketplace.CMS_MARKETPLACE_BASE_URL") . $endpoint;
        $params = [
            'query' => [
                'apikey' => $token,
                'q' => $query,
                'type' => $type
            ]
        ];
        if ($specialty != '') {
            $params['query']['specialty'] = $specialty;
        }
        $client = new Client();
        try {
            $response = $client->request('GET', $url, $params);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            if ($statusCode >= 200 && $statusCode < 300) {
                return json_decode($body);
            } else {
                Log::error('Fail to get States: ' . $statusCode . ' - ' . $body);
                return false;
            }
        } catch (GuzzleException | Exception $e) {
            Log::error('Fail to get States: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public static function getStateMedicaid(string $abbrev, string $year = '', string $quarter = '')
    {
        $endpoint = 'states/{abbrev}/medicaid';
        $token = config("cmsmarketplace.CMS_MARKETPLACE_TOKEN");
        $url = config("cmsmarketplace.CMS_MARKETPLACE_BASE_URL") . $endpoint;
        $url = str_replace('{abbrev}', $abbrev, $url);
        $params = [
            'query' => [
                'apikey' => $token,
            ]
        ];
        if ($year != '') {
            $params['query']['year'] = $year;
        }
        if ($quarter != '') {
            $params['query']['quarter'] = $quarter;
        }
        $client = new Client();
        try {
            $response = $client->request('GET', $url, $params);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            if ($statusCode >= 200 && $statusCode < 300) {
                return json_decode($body);
            } else {
                Log::error('Fail to get State Medicaids: ' . $statusCode . ' - ' . $body);
                return false;
            }
        } catch (GuzzleException | Exception $e) {
            Log::error('Fail to get State Medicaids: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public static function getPlans(string $year, array $reqBody)
    {
        $endpoint = 'plans';
        $token = config("cmsmarketplace.CMS_MARKETPLACE_TOKEN");
        $url = config("cmsmarketplace.CMS_MARKETPLACE_BASE_URL") . $endpoint;
        $params = [
            'query' => [
                'apikey' => $token,
            ]
        ];
        $params['query']['year'] = $year;
        $params['body'] = json_encode($reqBody);
        $client = new Client();
        try {
            $response = $client->request('POST', $url, $params);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            if ($statusCode >= 200 && $statusCode < 300) {
                return json_decode($body);
            } else {
                Log::error('Fail to get Plans list: ' . $statusCode . ' - ' . $body);
                return false;
            }
        } catch (GuzzleException | Exception $e) {
            Log::error('Fail to get Plans list: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public static function getPlansSearch(string $year, array $reqBody)
    {

        $endpoint = 'plans/search';
        $token = config("cmsmarketplace.CMS_MARKETPLACE_TOKEN");
        $url = config("cmsmarketplace.CMS_MARKETPLACE_BASE_URL") . $endpoint;
        $params = [
            'query' => [
                'apikey' => $token,
            ]
        ];
        $params['query']['year'] = $year;
        $params['body'] = json_encode($reqBody);
        $client = new Client();
        try {
            $response = $client->request('POST', $url, $params);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            if ($statusCode >= 200 && $statusCode < 300) {
                return json_decode($body);
            } else {
                Log::error('Fail to get Plan: ' . $statusCode . ' - ' . $body);
                return false;
            }
        } catch (GuzzleException | Exception $e) {
            Log::error('Fail to get Plan: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public static function getPlansSearchStats(string $year, array $reqBody)
    {
        $endpoint = 'plans/search/stats';
        $token = config("cmsmarketplace.CMS_MARKETPLACE_TOKEN");
        $url = config("cmsmarketplace.CMS_MARKETPLACE_BASE_URL") . $endpoint;
        $params = [
            'query' => [
                'apikey' => $token,
            ]
        ];
        $params['query']['year'] = $year;
        $params['body'] = json_encode($reqBody);
        $client = new Client();
        try {
            $response = $client->request('POST', $url, $params);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            if ($statusCode >= 200 && $statusCode < 300) {
                return json_decode($body);
            } else {
                Log::error('Fail to get Plan Stats: ' . $statusCode . ' - ' . $body);
                return false;
            }
        } catch (GuzzleException | Exception $e) {
            Log::error('Fail to get Plan Stats: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public static function getPlan(string $plan_id, string $year)
    {
        $endpoint = 'plans/{plan_id}';
        $token = config("cmsmarketplace.CMS_MARKETPLACE_TOKEN");
        $url = config("cmsmarketplace.CMS_MARKETPLACE_BASE_URL") . $endpoint;
        $url = str_replace('{plan_id}', $plan_id, $url);
        $params = [
            'query' => [
                'apikey' => $token,
            ]
        ];
        $params['query']['year'] = $year;
        $client = new Client();
        try {
            $response = $client->request('GET', $url, $params);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            if ($statusCode >= 200 && $statusCode < 300) {
                return json_decode($body);
            } else {
                Log::error('Fail to get Plan by id: ' . $statusCode . ' - ' . $body);
                return false;
            }
        } catch (GuzzleException | Exception $e) {
            Log::error('Fail to get Plan by id: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public static function getPlanWithPremiums(string $plan_id, string $year, array $reqBody)
    {
        $endpoint = 'plans/{plan_id}';
        $token = config("cmsmarketplace.CMS_MARKETPLACE_TOKEN");
        $url = config("cmsmarketplace.CMS_MARKETPLACE_BASE_URL") . $endpoint;
        $url = str_replace('{plan_id}', $plan_id, $url);
        $params = [
            'query' => [
                'apikey' => $token,
            ]
        ];
        $params['query']['year'] = $year;
        $params['body'] = json_encode($reqBody);
        $client = new Client();
        try {
            $response = $client->request('POST', $url, $params);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            if ($statusCode >= 200 && $statusCode < 300) {
                return json_decode($body);
            } else {
                Log::error('Fail to get Plan by id: ' . $statusCode . ' - ' . $body);
                return false;
            }
        } catch (GuzzleException | Exception $e) {
            Log::error('Fail to get Plan by id: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public static function getHouseholdEligibilityEstimates(string $year, array $estimate)
    {
        $endpoint = 'households/eligibility/estimates';
        $token = config("cmsmarketplace.CMS_MARKETPLACE_TOKEN");
        $url = config("cmsmarketplace.CMS_MARKETPLACE_BASE_URL") . $endpoint;
        $params = [
            'query' => [
                'apikey' => $token,
            ]
        ];
        $params['query']['year'] = $year;
        $params['body'] = json_encode($estimate);
        $client = new Client();
        try {
            $response = $client->request('POST', $url, $params);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            if ($statusCode >= 200 && $statusCode < 300) {
                return json_decode($body);
            } else {
                Log::error('Fail to get household eligibility estimates: ' . $statusCode . ' - ' . $body);
                return false;
            }
        } catch (GuzzleException | Exception $e) {
            Log::error('Fail to get household eligibility estimates: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public static function getHouseholdEligibilitySlcsp(string $year, array $slcsp)
    {
        $endpoint = 'households/slcsp';
        $token = config("cmsmarketplace.CMS_MARKETPLACE_TOKEN");
        $url = config("cmsmarketplace.CMS_MARKETPLACE_BASE_URL") . $endpoint;
        $params = [
            'query' => [
                'apikey' => $token,
            ]
        ];
        $params['query']['year'] = $year;
        $params['body'] = json_encode($slcsp);
        $client = new Client();
        try {
            $response = $client->request('POST', $url, $params);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            if ($statusCode >= 200 && $statusCode < 300) {
                return json_decode($body);
            } else {
                Log::error('Fail to get household slcsp: ' . $statusCode . ' - ' . $body);
                return false;
            }
        } catch (GuzzleException | Exception $e) {
            Log::error('Fail to get household slcsp: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public static function getCountiesByZip(string $zipcode, string $year)
    {
        $endpoint = 'counties/by/zip/{zipcode}';
        $token = config("cmsmarketplace.CMS_MARKETPLACE_TOKEN");
        $url = config("cmsmarketplace.CMS_MARKETPLACE_BASE_URL") . $endpoint;
        $url = str_replace('{zipcode}', $zipcode, $url);
        $params = [
            'query' => [
                'apikey' => $token,
            ]
        ];
        $params['query']['year'] = $year;
        $client = new Client();
        try {
            $response = $client->request('GET', $url, $params);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            if ($statusCode >= 200 && $statusCode < 300) {
                return json_decode($body);
            } else {
                Log::error('Fail to get Counties by zipcode: ' . $statusCode . ' - ' . $body);
                return false;
            }
        } catch (GuzzleException | Exception $e) {
            Log::error('Fail to get Counties by zipcode: ' . $e->getMessage());
            return false;
        }
    }



    /**
     * @throws Exception
     */
    public static function getDrugsAutocomplete(string $query)
    {
        $endpoint = 'drugs/autocomplete';
        $token = config("cmsmarketplace.CMS_MARKETPLACE_TOKEN");
        $url = config("cmsmarketplace.CMS_MARKETPLACE_BASE_URL") . $endpoint;
        $params = [
            'query' => [
                'apikey' => $token,
                'q' => $query
            ]
        ];

        $client = new Client();
        try {
            Log::info('Sending request to CMS API', ['url' => $url, 'params' => $params]);
            $response = $client->request('GET', $url, $params);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            Log::info('Received response from CMS API', ['statusCode' => $statusCode, 'body' => $body]);

            if ($statusCode >= 200 && $statusCode < 300) {
                return json_decode($body);
            } else {
                Log::error('Fail to get drugs autocomplete: ' . $statusCode . ' - ' . $body);
                return false;
            }
        } catch (GuzzleException | Exception $e) {
            Log::error('Fail to get drugs autocomplete: ' . $e->getMessage());
            return false;
        }
    }

    public static function getProvidersAutocomplete(string $query, string $zipcode)
    {
        $endpoint = 'providers/autocomplete';
        $token    = config("cmsmarketplace.CMS_MARKETPLACE_TOKEN");
        $url      = config("cmsmarketplace.CMS_MARKETPLACE_BASE_URL") . $endpoint;

        $params = [
            'query' => [
                'apikey'  => $token,
                'q'       => $query,
                'zipcode' => $zipcode,
                'type'    => 'Individual,Facility,Group', // Inclui todos os tipos
            ]
        ];

        $client = new Client();
        try {
            Log::info('Sending request to CMS API for providers autocomplete', ['url' => $url, 'params' => $params]);
            $response = $client->request('GET', $url, $params);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            Log::info('Received response from CMS API', ['statusCode' => $statusCode, 'body' => $body]);

            if ($statusCode >= 200 && $statusCode < 300) {
                return json_decode($body, true);
            } else {
                Log::error('Fail to get providers autocomplete: ' . $statusCode . ' - ' . $body);
                return false;
            }
        } catch (\GuzzleHttp\Exception\GuzzleException | Exception $e) {
            Log::error('Fail to get providers autocomplete: ' . $e->getMessage());
            return false;
        }
    }
}
