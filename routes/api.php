<?php

use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\WebsiteController;
use App\Http\Controllers\API\RelationShipController;
use App\Http\Controllers\API\SubscribeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['prefix' => '/'] , function(){

    Route::apiResource('/users' , UserController::class);
    Route::apiResource('/websites' , WebsiteController::class);
    Route::apiResource('/posts' , PostController::class);
    Route::apiResource('/subscribes' , SubscribeController::class);
    Route::get('/users/{id}/websites' , [RelationShipController::class , 'userWebsites']);
    Route::get('/websites/{id}/posts' , [RelationShipController::class , 'websitePosts']);

    Route::any('user' , function() {
        $message = "please make sure to update your code to use the newer version of our API.
        You should use users instead of user";
        return Response([
            'data' => $message,
            'link' => url('documentation/api'),
        ],404);
    }); 

    Route::any('website' , function() {
        $message = "please make sure to update your code to use the newer version of our API.
        You should use websites instead of website";
        return Response([
            'data' => $message,
            'link' => url('documentation/api'),
        ],404);
    }); 

    Route::any('post' , function() {
        $message = "please make sure to update your code to use the newer version of our API.
        You should use posts instead of post";
        return Response([
            'data' => $message,
            'link' => url('documentation/api'),
        ],404);
    }); 

});
