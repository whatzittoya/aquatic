<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {

    Route::post('members/updateapi/{id}', 'API\MemberController@updateApi')->name('events');
    Route::apiResource('members', 'API\MemberController');
    Route::apiResource('clubs', 'API\ClubController');
    Route::apiResource('events', 'API\EventController');
    Route::apiResource('rules', 'API\RuleController');
    Route::apiResource('races', 'API\RaceController');

    Route::apiResource('participants', 'API\ParticipantController');
    Route::get('races/byevent/{id}', 'API\RaceController@byEvent');
    Route::post('events/racesstore', 'API\EventController@raceStore');
    Route::post('events/racesupdate/{id}', 'API\EventController@raceUpdate');

    Route::get('/role', function () {
        return response()->json(Auth::user()->getRole());
    });
});


// Route::get('test/{user}', function (App\User $user) {

//     dd($user->roles->hasAccess('manage-club'));
// });
