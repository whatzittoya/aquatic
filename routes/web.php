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
Route::get('email/{id}', 'RegistrationController@email')->name('events');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');
    Route::get('events', 'EventController@index')->name('events');
    Route::get('event/races/{id}', 'EventController@race')->name('events_race');
    Route::get('rules', 'RuleController@index')->name('rules');
    Route::get('races', 'RaceController@index')->name('races');
    Route::get('participants', 'ParticipantController@index')->name('participants');
    Route::resource('members', 'MemberController')->names([
        'index' => 'members'
    ]);
    Route::resource('clubs', 'ClubController')->names([
        'index' => 'clubs'
    ]);
    Route::resource('/passwords/change', 'ChangePassController')->names(['index' => 'change_pass']);
});

Route::get('/{url}', function ($url) {

    return view('other/under_construction');
})->where('url', '(about|events|contact)'); // the pipe denotes 'or'
