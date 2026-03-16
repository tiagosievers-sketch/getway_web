<?php

namespace App\Actions;

use App\Http\Requests\GetStateMedicaidRequest;
use App\Http\Resources\StateCollection;
use App\Http\Resources\StateMedicaidCollection;
use App\Http\Resources\StateMedicaidResource;
use App\Libraries\CmsHttpLibrary;
use App\Models\State;
use App\Models\StateMedicaid;
use App\Models\StateMedicaidLic;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\Self_;

class StateActions
{
    private const YEAR = '2025';

    /**
     * @throws Exception
     */
    public static function getStates(string $year=self::YEAR, bool $storeStates = true): mixed
    {
        $statesResponse = CmsHttpLibrary::getStates($year);
        if(isset($statesResponse->states)){
            if($storeStates){
                foreach ($statesResponse->states as $state) {
                    $storedState = State::where('name', $state->name)->first();
                    $stateData = [
                        'name' => $state->name ?? '',
                        'abbrev' => $state->abbrev ?? '',
                        'fips' => $state->fips ?? '',
                        'marketplace_model' => $state->marketplace_model ?? '',
                        'shop_marketplace_model' => $state->shop_marketplace_model ?? '',
                        'hix_name' => $state->hix_name ?? '',
                        'hix_url' => $state->hix_url ?? '',
                        'shop_hix_name' => $state->shop_hix_name ?? '',
                        'shop_hix_url' => $state->shop_hix_url ?? '',
                        '8962_link' => $state->{'8962_link'} ?? '',
                        '8965_link' => $state->{'8965_link'} ?? '',
                        'assister_program_url' => $state->assister_program_url ?? ''
                    ];
                    if ($storedState) {
                        $storedState->update($stateData);
                    } else {
                        State::create($stateData);
                    }
                }
            }
            return $statesResponse;
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public static function listStates(Request $request): StateCollection
    {
        $stateArray = State::all()->load('counties');
        $now = \Carbon::now();
        if(count($stateArray) == 0){
            self::getStates(self::YEAR, true);
            $stateArray = State::all()->load('counties');
        }
        return new StateCollection($stateArray);
    }

    /**
     * @throws Exception
     */
    public static function getStateMedicaid(GetStateMedicaidRequest $request,  bool $storeMedicaid = false): StateMedicaidResource|\stdClass
    {
        $abbrev = strtoupper($request->input('abbrev'));
        if($abbrev!=''){
            $year = $request->input('year')??'';
            $quarter = $request->input('quarter')??'';
            $medicaidResponse = CmsHttpLibrary::getStateMedicaid($abbrev,$year,$quarter);
            if($medicaidResponse){
                if($storeMedicaid){
                    $medicaid = StateMedicaid::where('abbrev', $abbrev)->first();
                    $medicaidData = [
                        'name' => $medicaidResponse->name ?? '',
                        'abbrev' => $medicaidResponse->abbrev ?? '',
                        'fiscal_year' => $medicaidResponse->fiscal_year ?? '',
                        'fiscal_quarter' => $medicaidResponse->fiscal_quarter ?? '',
                        'pc_fpl_parent' => $medicaidResponse->pc_fpl_parent ?? '',
                        'pc_fpl_pregnant' => $medicaidResponse->pc_fpl_pregnant ?? '',
                        'pc_fpl_adult' => $medicaidResponse->pc_fpl_adult ?? '',
                        'pc_fpl_child_newborn' => $medicaidResponse->pc_fpl_child_newborn ?? '',
                        'pc_fpl_child_1_5' => $medicaidResponse->pc_fpl_child_1_5 ?? '',
                        'pc_fpl_child_6_18' => $medicaidResponse->pc_fpl_child_6_18 ?? ''
                    ];
                    if ($medicaid) {
                        $update = $medicaid->update($medicaidData);
                        if ($update) {
                            $medicaid->load(['lics', 'chips']);
                            if (count($medicaid->lics)) {
                                foreach ($medicaid->lics as $lic) {
                                    if (count($medicaidResponse->low_income_child)) {
                                        $resLic = reset($medicaidResponse->low_income_child);
                                        $licData = [
                                            'chip' => 0,
                                            'min_age' => $resLic->min_age ?? '',
                                            'max_age' => $resLic->max_age ?? '',
                                            'pc_fpl' => $resLic->pc_fpl ?? '',
                                            'state_medicaid_id' => $medicaid->id
                                        ];
                                        $lic->update($licData);
                                    } else {
                                        $lic->delete();
                                    }
                                }
                            } else {
                                if (count($medicaidResponse->low_income_child)) {
                                    $resLic = reset($medicaidResponse->low_income_child);
                                    $licData = [
                                        'chip' => 0,
                                        'min_age' => $resLic->min_age ?? '',
                                        'max_age' => $resLic->max_age ?? '',
                                        'pc_fpl' => $resLic->pc_fpl ?? '',
                                        'state_medicaid_id' => $medicaid->id
                                    ];
                                    StateMedicaidLic::create($licData);
                                }
                            }
                            if (count($medicaid->chips)) {
                                foreach ($medicaid->chips as $chip) {
                                    if (count($medicaidResponse->chip)) {
                                        $resChip = reset($medicaidResponse->chip);
                                        $chipData = [
                                            'chip' => 1,
                                            'min_age' => $resChip->min_age ?? '',
                                            'max_age' => $resChip->max_age ?? '',
                                            'pc_fpl' => $resChip->pc_fpl ?? '',
                                            'state_medicaid_id' => $medicaid->id
                                        ];
                                        $chip->update($chipData);
                                    } else {
                                        $chip->delete();
                                    }
                                }
                            } else {
                                if (count($medicaidResponse->chip)) {
                                    $resChip = reset($medicaidResponse->chip);
                                    $chipData = [
                                        'chip' => 1,
                                        'min_age' => $resChip->min_age ?? '',
                                        'max_age' => $resChip->max_age ?? '',
                                        'pc_fpl' => $resChip->pc_fpl ?? '',
                                        'state_medicaid_id' => $medicaid->id
                                    ];
                                    StateMedicaidLic::create($chipData);
                                }
                            }
                        }
                        return new StateMedicaidResource($medicaid->load(['lics', 'chips']));
                    }
                    $medicaid = StateMedicaid::create($medicaidData);
                    if (count($medicaidResponse->low_income_child)) {
                        $resLic = reset($medicaidResponse->low_income_child);
                        $licData = [
                            'chip' => 0,
                            'min_age' => $resLic->min_age ?? '',
                            'max_age' => $resLic->max_age ?? '',
                            'pc_fpl' => $resLic->pc_fpl ?? '',
                            'state_medicaid_id' => $medicaid->id
                        ];
                        StateMedicaidLic::create($licData);
                    }
                    if (count($medicaidResponse->chip)) {
                        $resChip = reset($medicaidResponse->chip);
                        $chipData = [
                            'chip' => 1,
                            'min_age' => $resChip->min_age ?? '',
                            'max_age' => $resChip->max_age ?? '',
                            'pc_fpl' => $resChip->pc_fpl ?? '',
                            'state_medicaid_id' => $medicaid->id
                        ];
                        StateMedicaidLic::create($chipData);
                    }
                    return new StateMedicaidResource($medicaid->load(['lics', 'chips']));
                }
                return $medicaidResponse;
            } else {
                return new StateMedicaidResource(array());
            }
        } else {
            return new StateMedicaidResource(array());
        }
    }

    public static function listMedicaids(Request $request): StateMedicaidCollection
    {
        return new StateMedicaidCollection(
            StateMedicaid::orderBy('name', 'asc')->get()
        );
    }
}
