<?php

namespace App\Actions;

use App\Http\Requests\GetProvidersCoverageRequest;
use App\Libraries\CmsHttpLibrary;
use App\Models\State;
use Exception;

class ProvidersCoverageActions
{
    private const YEAR = '2019';

    /**
     * @throws Exception
     */
    public static function providersCoverage(GetProvidersCoverageRequest $request)
    {
        $query = $request->input('query');
        $zipcode = $request->input('zipcode');
        $coverageSearchResp = CmsHttpLibrary::getCoverageSearch($query,$zipcode);
        $retArray = ['providers' => [], 'drugs' => []];
        if(isset($coverageSearchResp->providers)){
            $retArray['providers'] = $coverageSearchResp->providers;
        }
        if(isset($coverageSearchResp->drugs)){
            $retArray['drugs'] = $coverageSearchResp->drugs;
        }
        return $retArray;
    }

    /**
     * @throws Exception
     */
    public static function providersSearch(GetProvidersCoverageRequest $request)
    {
        $query = $request->input('query');
        $zipcode = $request->input('zipcode');
        $coverageSearchResp = CmsHttpLibrary::getCoverageSearch($query,$zipcode);
        $retArray = ['providers' => [], 'drugs' => []];
        if(isset($coverageSearchResp->providers)){
            $retArray['providers'] = $coverageSearchResp->providers;
        }
        if(isset($coverageSearchResp->drugs)){
            $retArray['drugs'] = $coverageSearchResp->drugs;
        }
        return $retArray;
    }
}
