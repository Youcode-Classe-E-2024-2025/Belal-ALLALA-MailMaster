<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SubscriberController;
use App\Http\Controllers\Api\NewsletterController;
use App\Http\Controllers\Api\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('subscribers', SubscriberController::class);
    Route::apiResource('newsletters', NewsletterController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('campaigns', CampaignController::class);
    Route::post('/campaigns/{campaign}/send', [CampaignController::class, 'send']);
    Route::get('/campaigns/{campaign}/preview', [CampaignController::class, 'preview']); 
});


Route::post('/register', [AuthController::class, 'register']); 
Route::post('/login', [AuthController::class, 'login']);
Route::get('/track-open/{campaign}/{subscriber}', [CampaignController::class, 'trackOpen'])->name('track.open');

