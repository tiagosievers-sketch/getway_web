<?php

namespace App\Actions;

use App\Libraries\CmsHttpLibrary;
use App\Models\County;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CountyActions
{
    private const YEAR = '2019';

    /**
     * @throws Exception
     */
    public static function getCountiesByZipcode(string $zipcode, Request $request, bool $storeCounties = false)
    {
        $year = $request->query('year');
        $statesResponse = CmsHttpLibrary::getCountiesByZip($zipcode,$year??self::YEAR);
        if(isset($statesResponse->counties)){
            foreach ($statesResponse->counties as $county) {
                if($storeCounties){
                    $storedCounty = County::where('fips', $county->fips)->first();
                    $countyData = [
                        'fips' => $county->fips ?? '',
                        'name' => $county->name ?? '',
                        'state' => $county->state ?? '',
                        'zipcode' => $county->zipcode ?? ''
                    ];
                    if ($storedCounty) {
                        $storedCounty->update($countyData);
                    } else {
                        $storedCounty = County::create($countyData);
                    }
                }
            }
            return $statesResponse;
        }
        throw new Exception("It was not possible to recover counties by zipcode.");
    }

    /**
     * @throws Exception
     */
    public static function listCountiesByZipcode(string $zipcode, Request $request)
    {
        $year = $request->query('year');
        $storedCounties = County::where('zipcode', $zipcode)->get();
        if(!$storedCounties){
            $statesResponse = CmsHttpLibrary::getCountiesByZip($zipcode,$year??self::YEAR);
            if(isset($statesResponse->counties)){
                foreach ($statesResponse->counties as $county) {
                    $countyData = [
                        'fips' => $county->fips ?? '',
                        'name' => $county->name ?? '',
                        'state' => $county->state ?? '',
                        'zipcode' => $county->zipcode ?? ''
                    ];
                    $storedCounties[] = County::create($countyData);
                }
            }
        }
        if(count($storedCounties) > 0){
            return $storedCounties->toArray();
        }
        throw new Exception("It was not possible to recover counties by zipcode.");
    }
}
