<?php

namespace App\Actions;

use App\Http\Requests\GetHouseholdEligibilityEstimatesRequest;
use App\Http\Requests\GetHouseholdSlcspRequest;
use App\Libraries\CmsHttpLibrary;
use Exception;
use Illuminate\Http\Request;

class HouseholdsEligibilityActions
{
    private const YEAR = '2019';

    /**
     * @throws Exception
     */
    public static function getEstimates(GetHouseholdEligibilityEstimatesRequest $request)
    {
        $year = $request->query('year');
        $body = $request->validated();
        $response = CmsHttpLibrary::getHouseholdEligibilityEstimates($year,$body);
        return $response??array();
    }


    /**
     * @throws Exception
     */
    public static function getSlcsp(GetHouseholdSlcspRequest $request)
    {
        $year = $request->query('year');
        $body = $request->validated();
        $response = CmsHttpLibrary::getHouseholdEligibilitySlcsp($year,$body);
        return $response??array();
    }
}
