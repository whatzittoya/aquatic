<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/test', function () {
    return view('test');
})->where('any', '.*');

Route::get('stest/{msg}', 'RuleController@test');
Auth::routes();
Route::resource('register', 'RegistrationController')->names([
    'index' => 'register'
]);
Route::get('email/{id}', 'RegistrationController@email');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');
    Route::get('/home/{id}', function () {
        return view('admin.liveMatch');
    })->name('livematch');
    Route::get('events', 'EventController@index')->name('events');
    Route::get('event/races/{id}', function () {
        return view('admin.eventRace');
    })->name('events_race');
    Route::get('event/participants/{id}', function () {
        return view('admin.eventParticipant');
    })->name('events_race');
    Route::get('event/matches/{id}', function () {
        return view('admin.eventMatch');
    })->name('events_match');
    Route::get('rules', 'RuleController@index')->name('rules');
    Route::get('/races', function () {
        return view('admin.pure_races');
    })->name('races');
    Route::get('participants', 'ParticipantController@index')->name('participants');
    Route::resource('members', 'MemberController')->names([
        'index' => 'members'
    ]);
    Route::resource('clubs', 'ClubController')->names([
        'index' => 'clubs'
    ]);
    Route::resource('/passwords/change', 'ChangePassController')->names(['index' => 'change_pass']);
    Route::resource('/profile', 'ProfileController')->names(['index' => 'profile', 'store' => 'u_profile']);
    Route::get('/startinglist', function () {
        return view('admin.startingList');
    })->name('starting_list');

    Route::get('/startinglist/export_excel/{id}', 'StartingListController@export_excel');


    Route::resource('payments', 'PaymentController')->names([
        'index' => 'payment'
    ]);
});

Route::get('/{url}', function ($url) {

    return view('other/under_construction');
})->where('url', '(about|events|contact)'); // the pipe denotes 'or'
