<?php

namespace App\Actions;

use App\Http\Requests\GetPlansRequest;
use App\Http\Requests\GetPlansSearchRequest;
use App\Http\Requests\GetPlanWithPremiumsRequest;
use App\Http\Requests\GetProvidersCoverageRequest;
use App\Http\Resources\PlanCollection;
use App\Libraries\CmsHttpLibrary;
use App\Models\State;
use Exception;
use Illuminate\Http\Request;

class InsurancePlansActions
{
    private const YEAR = '2019';

    /**
     * @throws Exception
     */
    public static function plans(GetPlansRequest $request)
    {
        $year = $request->query('year');
        $body = $request->validated();
        $response = CmsHttpLibrary::getPlans($year, $body);
        return $response->plans ?? array();
    }

    /**
     * @throws Exception
     */
    public static function plansSearch(GetPlansSearchRequest $request)
    {
        $year = $request->input('year');
        $body = $request->validated();

        // if ($request->has('rxcui')) {
        //     $body['filter']['drugs'] = $request->input('rxcui');
        // }

        if ($request->has('filter.drugs')) {
            $body['filter']['drugs'] = $request->input('filter.drugs');
        }

        $response = CmsHttpLibrary::getPlansSearch($year, $body);
        return $response ?? array();
    }

    /**
     * @throws Exception
     */
    public static function plansSearchStats(GetPlansSearchRequest $request)
    {
        $year = $request->query('year');
        $body = $request->validated();
        $response = CmsHttpLibrary::getPlansSearchStats($year, $body);
        return $response ?? array();
    }

    /**
     * @throws Exception
     */
    public static function getPlan(string $plan_id, Request $request)
    {
        $year = $request->query('year');
        $response = CmsHttpLibrary::getPlan($plan_id, $year);
        return $response ?? array();
    }



    /**
     * @throws Exception
     */
    public static function getPlanWithPremiums(string $plan_id, GetPlanWithPremiumsRequest $request)
    {
        $year = $request->query('year');
        $body = $request->validated();
        $response = CmsHttpLibrary::getPlanWithPremiums($plan_id, $year, $body);
        return $response ?? array();
    }


    /**
     * @throws Exception
     */
    public static function getDrugsAutocomplete(string $query)
    {
        $response = CmsHttpLibrary::getDrugsAutocomplete($query);
        \Log::info('Drugs autocomplete response', ['response' => $response]);

        // Verifique se a resposta contém os dados esperados e retorne-os
        if (is_array($response) && !empty($response)) {
            return $response;
        }

        return [];
    }
    /**
     * @throws Exception
     */
    public static function getProvidersAutocomplete(string $query, string $zipcode)
    {
        $response = CmsHttpLibrary::getProvidersAutocomplete($query, $zipcode);
        \Log::info('Providers autocomplete response', ['response' => $response]);

        if (is_array($response) && !empty($response)) {
            return $response;
        }

        return [];
    }
}
