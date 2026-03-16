<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CountyController;
use App\Http\Controllers\HouseholdsEligibilityController;
use App\Http\Controllers\InsurancePlansController;
use App\Http\Controllers\ProvidersCoverageController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return 'Laravel API '.app()->version();
});
Route::get('/phpinfo', function () {
    return phpinfo();
});
Route::group(['middleware' => ['forcejson:api']], function () {
    Route::prefix('v1')->name('v1.')->group(function () {
        Route::prefix('auth')->name('auth.')->group(function () {
            Route::post('/register-email', [AuthController::class, 'register']);
            Route::post('/login-email', [AuthController::class, 'login']);
            Route::middleware([
                'auth:sanctum',
                config('jetstream.auth_session'),
                'verified',
            ])->group(function () {
                Route::post('/logout', [AuthController::class, 'logout']);
            });
        });
        Route::middleware([
            'auth:sanctum',
            config('jetstream.auth_session'),
            'verified',
        ])->group(function () {
            Route::prefix('admin')->name('admin.')->group(function () {
                Route::apiResource('users', UserController::class, [
                    'parameters' => [
                        'users' => 'user',
                    ],
                ])->only([
                    'index',
//            'show','store','update','destroy'
                ]);
            });
            Route::prefix('provider')->name('provider.')->group(function () {
                Route::get('/coverage', [ProvidersCoverageController::class, 'coverage']);
                Route::get('/search', [ProvidersCoverageController::class, 'search']);
            });
            Route::prefix('plans')->name('plans.')->group(function () {
                Route::post('/', [InsurancePlansController::class, 'plans']);
                Route::post('/search', [InsurancePlansController::class, 'plansSearch']);
                Route::post('/search/stats', [InsurancePlansController::class, 'plansSearchStats']);
                Route::get('/{plan_id}', [InsurancePlansController::class, 'plan']);
                Route::post('/{plan_id}', [InsurancePlansController::class, 'planWithPremiums']);
                Route::get('/drugs/autocomplete', [InsurancePlansController::class, 'getDrugsAutocomplete']); 
                Route::get('/providers/autocomplete', [InsurancePlansController::class, 'getProvidersAutocomplete']); 
            });
            Route::prefix('households-elegibility')->name('households.')->group(function () {
                Route::post('/estimates', [HouseholdsEligibilityController::class, 'estimates']);
                Route::post('/slcsp', [HouseholdsEligibilityController::class, 'slcsp']);
            });
            Route::prefix('geography')->name('geography.')->group(function () {
                Route::prefix('states')->name('states.')->group(function () {
                    Route::get('/', [StateController::class, 'getAllStates']);
                    Route::prefix('medicaid')->name('medicaid.')->group(function () {
                        Route::get('/', [StateController::class, 'getStateMedicaid']);
                        Route::apiResource('/db', StateController::class, [
                            'parameters' => [
                                'db' => 'medicaid',
                            ],
                        ])->only([
                            'index'
                        ]);
                    });
                });
                Route::prefix('counties')->name('counties.')->group(function () {
                    Route::get('/zipcode/{zipcode}', [CountyController::class, 'countiesByZip']);
                });
            });
        });
    });
});
