<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/swagger-gen', '\App\Http\Controllers\SwaggerController@swaggerGen');
Route::get('', function () {
    return redirect('/login');
});
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/user/dashboard', [UserController::class, 'userDashboard'])->name('dashboard');
        Route::get('/admin/users', [UserController::class, 'userDashboard'])->name('admin.user.dashboard');
        Route::get('/create/user', [UserController::class, 'create'])->name('user.create');
        Route::delete('/user/{id}', [UserController::class, 'delete'])->name('user.delete');
        Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::post('/save/user', [UserController::class, 'save'])->name('user.save');

    });
});


