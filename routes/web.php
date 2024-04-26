<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
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
Route::group(['prefix' => 'backend'], function() {
	Auth::routes(['verify' => true]);
});

// Localization route
Route::get('lang/{locale}', 'App\Http\Controllers\HomeController@lang')->name('locale');

//AUTH
Auth::routes();
Route::post('/loginUser', 'App\Http\Controllers\Auth\LoginController@loginUser')->name('loginUser');
Route::post('/registerUser', 'App\Http\Controllers\Auth\RegisterController@register')->name('registerUser');

//front page
Route::get('/',[HomeController::class , 'index'])->name('firstPage');

Route::get('/404', 'App\Http\Controllers\CmsController@page_notFound')->name('404Page');

Route::group(['middleware' => ['checkUser:Customer']], function() {

    //Matches
    Route::get('/matches', 'App\Http\Controllers\theme\MatchController@index')->name('matchPage');
    Route::post('/get_matches', 'App\Http\Controllers\theme\MatchController@ajax')->name('getMatches');
    Route::get('/viewd_matches', 'App\Http\Controllers\theme\MatchController@viwedMatches')->name('viwed-matches');
    Route::get('/search-matches', 'App\Http\Controllers\theme\MatchController@search')->name('searchMatchesPage');
    Route::post('/get_search_matches', 'App\Http\Controllers\theme\MatchController@ajax_search')->name('searchMatches');
    Route::get('/your_match', 'App\Http\Controllers\theme\MatchController@yourMatch')->name('yourMatch');

    // CMS
    Route::get('/about-us', 'App\Http\Controllers\CmsController@aboutUs')->name('about-us');
    Route::get('/contact-us', 'App\Http\Controllers\CmsController@contactUs')->name('contact-us');
    Route::get('/terms', 'App\Http\Controllers\CmsController@terms')->name('terms');
    Route::get('/privacy', 'App\Http\Controllers\CmsController@privacy')->name('privacy');
    Route::get('/data', 'App\Http\Controllers\CmsController@data')->name('data');

    //Chat
    Route::get('/chat', 'App\Http\Controllers\theme\ChatController@index')->name('chatPage');
    Route::get('/chat-user-data/{id}', 'App\Http\Controllers\theme\ChatController@usersdata')->name('chat-user-data');
    Route::post('/send-message', 'App\Http\Controllers\theme\ChatController@sendMessage')->name('send-message');
    Route::post('/chat-list', 'App\Http\Controllers\theme\ChatController@chatList')->name('chat-list');

    //Interest
    Route::get('/interest', 'App\Http\Controllers\theme\ProfileController@interest')->name('interest');
    Route::post('/interest-list', 'App\Http\Controllers\theme\ProfileController@ajax_interest_list')->name('interest-list');
    Route::get('/interest-status-change/{status}/{id}', 'App\Http\Controllers\theme\ChatController@change_interestStatus')->name('interest-status-change');

    //Plan
    // Route::get('/plan', 'App\Http\Controllers\theme\PlanController@index')->name('planPage');

    // Profile
    Route::get('/complete-profile/{id?}', 'App\Http\Controllers\theme\ProfileController@complete_profile')->name('complete-profile');
    Route::post('/completeProfile', 'App\Http\Controllers\theme\ProfileController@post_complete_profile')->name('completeProfile');
    Route::get('/profile', 'App\Http\Controllers\theme\ProfileController@profile')->name('profile');
    Route::post('/profile', 'App\Http\Controllers\theme\ProfileController@ajax_profile')->name('ajax.profile');
    Route::get('/profile/{id}', 'App\Http\Controllers\theme\ProfileController@user_profile')->name('userProfile');
    Route::get('/edit-profile', 'App\Http\Controllers\theme\ProfileController@edit')->name('edit-profile');
    Route::post('/update-user-bio', 'App\Http\Controllers\theme\ProfileController@update')->name('update-user-bio');
    Route::get('/live-data-fetch/{id}', 'App\Http\Controllers\theme\ProfileController@getLiveData');
    Route::post('/question-answer', 'App\Http\Controllers\theme\ProfileController@answer_question')->name('question_answer');
    Route::get('/save-interest/{user_id}', 'App\Http\Controllers\theme\ProfileController@save_interest');
    Route::post('/save-partner-preference', 'App\Http\Controllers\theme\ProfileController@save_partner_preference')->name('save-partner-preference');

    // MY Account
    // Route::post('/loginProtal', 'App\Http\Controllers\Auth\LoginController@loginUser')->name('loginProtal');
    // Route::get('/my-account', 'App\Http\Controllers\AccountController@index')->name('myAccount');
    // Route::get('/my-account/orders', 'App\Http\Controllers\AccountController@myOrders')->name('myOrders');
    // Route::get('/my-account/wish-list', 'App\Http\Controllers\AccountController@wishList')->name('myWishList');
    // Route::get('/profile-settings', 'App\Http\Controllers\AccountController@settings')->name('profileSettings');
    // Route::post('/updateProfile', 'App\Http\Controllers\AccountController@updateProfile')->name('updateProfile');

});

// DEVELOPER
// Route::group(['middleware' => ['auth'],'prefix' => 'developer'], function() {
//     Route::get('/developer','App\Http\Controllers\Developer\HomeController@index')->name('developer.Dashboard');
//     Route::resource('roles','App\Http\Controllers\Developer\RoleController');
// 	Route::resource('permissions','App\Http\Controllers\Developer\PermissionController')->except(['show','edit','update']);
// });

// SUPERADMIN
Route::group(['middleware' => ['auth','checkUser:superAdmin'],'prefix' => 'admin'], function() {

    Route::get('/','App\Http\Controllers\Admin\HomeController@index')->name('home');
    Route::get('/dashboard','App\Http\Controllers\Admin\HomeController@dashboard')->name('dashboard');
    Route::get('/data','App\Http\Controllers\Admin\HomeController@data')->name('data');

    // Vendors
	Route::resource('users', 'App\Http\Controllers\Admin\UserController');
	Route::post('/users/ajax','App\Http\Controllers\Admin\UserController@ajax')->name('users_list');
	// Route::post('/saveRestaurants','App\Http\Controllers\Admin\UserController@store')->name('saveRestaurants');
	// Route::post('/updateRestaurants','App\Http\Controllers\Admin\UserController@update')->name('updateRestaurant');
	Route::post('/users/status','App\Http\Controllers\Admin\UserController@change_status')->name('change_user_status');
	Route::post('/users/approve_status','App\Http\Controllers\Admin\UserController@change_approve_status')->name('change_approve_status');

	Route::post('/updateUser','App\Http\Controllers\Admin\UserController@update')->name('updateUser');

    // Questions
	Route::resource('questions', 'App\Http\Controllers\Admin\QuestionController')->except('show');
	Route::post('/questions/ajax','App\Http\Controllers\Admin\QuestionController@ajax')->name('question_list');
	Route::post('/questions/status','App\Http\Controllers\Admin\QuestionController@change_status')->name('change_question_status');
	Route::post('/questions/destroy','App\Http\Controllers\Admin\QuestionController@destroy')->name('delete_question');

	// Options
	Route::get('/options/{id?}','App\Http\Controllers\Admin\OptionController@index')->name('optionPage');
	Route::get('/options/create/{id?}','App\Http\Controllers\Admin\OptionController@create')->name('optionCreate');
	Route::get('/options/edit/{id?}','App\Http\Controllers\Admin\OptionController@edit')->name('optionEdit');
	Route::post('/options/ajax','App\Http\Controllers\Admin\OptionController@ajax')->name('ajax_option_list');
	Route::post('/options/store','App\Http\Controllers\Admin\OptionController@store')->name('ajax_option_store');
	Route::post('/options/status','App\Http\Controllers\Admin\OptionController@change_status')->name('ajax_change_option_status');
	Route::post('/options/destroy','App\Http\Controllers\Admin\OptionController@destroy')->name('ajax_delete_option');

    // Language
	Route::resource('languages', 'App\Http\Controllers\Admin\LanguageController');
	Route::post('/languages/ajax','App\Http\Controllers\Admin\LanguageController@ajax')->name('ajax.language.list');
	Route::post('/languages/status','App\Http\Controllers\Admin\LanguageController@change_status')->name('ajax.change.language.status');
	Route::post('/languages/destroy','App\Http\Controllers\Admin\LanguageController@destroy')->name('ajax.delete.language');

    // LOCATIONS
	Route::resource('countries', 'App\Http\Controllers\Admin\Locations\CountryController');
	Route::post('/country-list','App\Http\Controllers\Admin\Locations\CountryController@ajax_list')->name('ajax.country.list');
	Route::post('/saveCountry','App\Http\Controllers\Admin\Locations\CountryController@store')->name('ajax.save.country');
	Route::post('/change-country-status','App\Http\Controllers\Admin\Locations\CountryController@change_status')->name('ajax.change.country.status');
	Route::post('/delete-country','App\Http\Controllers\Admin\Locations\CountryController@destroy')->name('ajax.delete.country');

	Route::resource('states', 'App\Http\Controllers\Admin\Locations\StateController');
	Route::post('/state-list','App\Http\Controllers\Admin\Locations\StateController@ajax_list')->name('ajax.state.list');
	Route::post('/save-state','App\Http\Controllers\Admin\Locations\StateController@store')->name('ajax.state.city');
	Route::post('/change-state-status','App\Http\Controllers\Admin\Locations\StateController@change_status')->name('ajax.change.state.status');
	Route::post('/delete-state','App\Http\Controllers\Admin\Locations\StateController@destroy')->name('ajax.delete.state');

	Route::resource('cities', 'App\Http\Controllers\Admin\Locations\CityController');
	Route::post('/city-list','App\Http\Controllers\Admin\Locations\CityController@ajax_list')->name('ajax.city.list');
	Route::post('/saveCity','App\Http\Controllers\Admin\Locations\CityController@store')->name('ajax.save.city');
	Route::post('/change-city-status','App\Http\Controllers\Admin\Locations\CityController@change_status')->name('ajax.change.city.status');
	Route::post('/delete-city','App\Http\Controllers\Admin\Locations\CityController@destroy')->name('ajax.delete.city');

	Route::resource('areas', 'App\Http\Controllers\Admin\Locations\AreaController');
	Route::post('/area-list','App\Http\Controllers\Admin\Locations\AreaController@ajax_list')->name('ajax.area.list');
	Route::post('/saveArea','App\Http\Controllers\Admin\Locations\AreaController@store')->name('ajax.save.area');
	Route::post('/change-area-status','App\Http\Controllers\Admin\Locations\AreaController@change_status')->name('ajax.change.area.status');
	Route::post('/delete-area','App\Http\Controllers\Admin\Locations\AreaController@destroy')->name('ajax.delete.area');

});
