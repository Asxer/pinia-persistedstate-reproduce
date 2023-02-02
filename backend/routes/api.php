<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\GirlAvailabilityLogController;
use App\Http\Controllers\UniformController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\CastingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DuoController;
use App\Http\Controllers\HairColorController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\FavorController;
use App\Http\Controllers\OrientationController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\NationalityController;
use App\Http\Controllers\DressSizeController;
use App\Http\Controllers\BustSizeController;
use App\Http\Controllers\GirlController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\SettingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
| We need to add throttle:60,1 here instead of Kernel because we need to remove
| this protection from dev environment to avoid backend failure while e2e tests are going on
*/

Route::group([
    'middleware' => array_filter([
        'auth',
        in_array(env('APP_ENV'), ['local', 'testing', 'development']) ? 'throttle:60,1' : null
    ])
], function () {
    Route::post('/countries', [CountryController::class, 'create']);
    Route::put('/countries/{id}', [CountryController::class, 'update']);
    Route::delete('/countries/{id}', [CountryController::class, 'delete']);
    Route::get('/countries/{id}', [CountryController::class, 'get']);
    Route::get('/countries', [CountryController::class, 'search']);


    Route::post('/cities', [CityController::class, 'create']);
    Route::put('/cities/{id}', [CityController::class, 'update']);
    Route::delete('/cities/{id}', [CityController::class, 'delete']);
    Route::get('/cities/{id}', [CityController::class, 'get']);
    Route::get('/cities', [CityController::class, 'search']);
});

Route::group(['middleware' => 'guest'], function () {
    Route::post('/login', ['uses' => AuthController::class . '@login']);
    Route::get('/auth/refresh', ['uses' => AuthController::class . '@refreshToken'])
        ->middleware(['jwt.refresh']);
});