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

    Route::get('clubs/valid', 'API\ClubController@indexValid');
    Route::apiResource('clubs', 'API\ClubController');

    Route::get('events/generatematch/{event_id}', 'API\EventController@generateMatch');
    Route::get('events/showcurrent', 'API\EventController@showCurrentEvent');
    Route::get('events/showlock', 'API\EventController@showLock');
    Route::apiResource('events', 'API\EventController');

    Route::apiResource('rules', 'API\RuleController');

    Route::apiResource('races', 'API\PureRaceController');

    Route::apiResource('participants', 'API\ParticipantController');

    Route::apiResource('startinglist', 'API\StartingListController');

    Route::get('events/races/available/{id}', 'API\EventRaceController@available');
    Route::apiResource('events/races', 'API\EventRaceController');

    Route::get('events/participants/lastrecord/{member_id}/{pure_race_id}', 'API\EventParticipantController@getLastRecord');
    Route::get('events/participants/members/{id}/{club_id}', 'API\EventParticipantController@getMember');
    Route::get('events/participants/races/{id}/{member_id}/{participant_id?}', 'API\EventParticipantController@getRace');
    Route::get('events/participants/members/{id}', 'API\EventParticipantController@getClubMember');
    Route::apiResource('events/participants', 'API\EventParticipantController');

    Route::apiResource('events/matches', 'API\EventMatchController');

    Route::post('payments/updateapi/{id}', 'API\PaymentController@updateApi');
    Route::apiResource('payments', 'API\PaymentController');

    Route::get('/role', function () {
        return response()->json(Auth::user()->getRole());
    });
});

Route::apiResource('liveresult', 'API\LiveResultController');




// Route::get('test/{user}', function (App\User $user) {

//     dd($user->roles->hasAccess('manage-club'));
// });
