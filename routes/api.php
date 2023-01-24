<?php

use App\Http\Controllers\ArticleCategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CampaignCategoryController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\ManualPaymentController;
use App\Http\Controllers\UpdateProfileController;
use App\Http\Controllers\UploadContentImageController;
use App\Http\Controllers\UserController;
use App\Http\Resources\UserDetailsResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum', 'verified'])->get('/user', function (Request $request) {
    return response()->json(UserDetailsResource::make($request->user()));
});

Route::apiResource('/campaigns', CampaignController::class)->only(['index', 'show']);
Route::apiResource('/articles', ArticleController::class)->only(['index', 'show']);
Route::apiResource('/article-categories', ArticleCategoryController::class)->only(['index', 'show']);
Route::apiResource('/campaign-categories', CampaignCategoryController::class)->only(['index', 'show']);
Route::group(['middleware' => ['auth:sanctum', 'role:Admin', 'verified']], function () {
    Route::apiResource('/users', UserController::class)->only(['index', 'update', 'destroy']);
    Route::apiResource('/articles', ArticleController::class)->only(['update', 'destroy', 'store']);
    Route::apiResource('/campaigns', CampaignController::class)->only(['update', 'destroy', 'store']);
    Route::apiResource('/article-categories', ArticleCategoryController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('/campaign-categories', CampaignCategoryController::class)->only(['store', 'update', 'destroy']);
    Route::put('/manual-payments/update-status', [ManualPaymentController::class, 'updateStatus']);
    Route::apiResource('/information', InformationController::class)->only(['store', 'update', 'destroy']);
    Route::post('/content-images', UploadContentImageController::class);
});
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::put('user/profile', UpdateProfileController::class);
    Route::apiResource('/manual-payments', ManualPaymentController::class)->only(['store', 'index']);
    Route::put('/manual-payments/upload-receipt', [ManualPaymentController::class, 'uploadReceipt']);
});
