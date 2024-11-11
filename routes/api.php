<?php

use App\Helpers\Enums\UserRoles;
use App\Http\Controllers\Api\AuthenticationController;
use Illuminate\Http\Request;
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

function registerResourceRoutes(string $group = UserRoles::USER): void
{
    AuthenticationController::registerRoutes($group);
}

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'user', 'middleware' => 'auth.user'], function () {
    registerResourceRoutes(UserRoles::USER);
});

Route::group(['namespace' => 'unauthenticated', 'middleware' => 'unauthenticated'], function () {
    registerResourceRoutes(UserRoles::ANONYMOUS);
});

Route::fallback(function () {
    abort(404);
});
