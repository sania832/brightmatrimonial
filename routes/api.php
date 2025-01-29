<?php

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

Route::prefix('customer')->group( function() {

	// Auth
	Route::post('login', 'App\Http\Controllers\Api\Customer\Auth\AuthController@login');
    Route::post('registration', 'App\Http\Controllers\Api\Customer\Auth\AuthController@registration');
    Route::post('activeAccount', 'App\Http\Controllers\Api\Customer\Auth\AuthController@active');
    Route::post('sendOTP', 'App\Http\Controllers\Api\Customer\Auth\AuthController@sendOTP');
    Route::post('verifyOTP', 'App\Http\Controllers\Api\Customer\Auth\AuthController@verifyOTP');
    Route::post('forgot_password', 'App\Http\Controllers\Api\Customer\Auth\AuthController@forgot_password');
    Route::middleware(['auth:api'])->group( function () {

		// Auth
		Route::get('logout', 'App\Http\Controllers\Api\Customer\Auth\AuthController@logout');
		Route::post('logout', 'App\Http\Controllers\Api\Customer\Auth\AuthController@logout');
		Route::post('reset_password', 'App\Http\Controllers\Api\Customer\Auth\AuthController@reset_password');
		Route::post('/support', 'App\Http\Controllers\UserSupportController@store');
		//USER
		Route::post('send_notification', 'App\Http\Controllers\Api\Customer\UserController@send_notification');
		Route::get('profile', 'App\Http\Controllers\Api\Customer\UserController@profile');
		Route::post('completeProfile', 'App\Http\Controllers\Api\Customer\UserController@save_profile');
		Route::get('get_myProfile', 'App\Http\Controllers\Api\Customer\UserController@profile');
		Route::get('get_dashboard_data', 'App\Http\Controllers\Api\Customer\UserController@dashboard_data');
		Route::post('updateProfile', 'App\Http\Controllers\Api\Customer\UserController@update');
		Route::post('update_profilePicture', 'App\Http\Controllers\Api\Customer\UserController@updateProfilePicture');
		Route::post('update_coverImage', 'App\Http\Controllers\Api\Customer\UserController@updateCoverImage');
		Route::get('gallery_images', 'App\Http\Controllers\Api\Customer\UserController@galleryImages');
		Route::post('upload_galleryImage', 'App\Http\Controllers\Api\Customer\UserController@uploadGalleryImage');
		Route::post('delete_galleryImage', 'App\Http\Controllers\Api\Customer\UserController@deleteGalleryImage');
		Route::post('update_bio', 'App\Http\Controllers\Api\Customer\UserController@update_bio');
		Route::post('update_deviceToken', 'App\Http\Controllers\Api\Customer\UserController@update_deviceToken');
		Route::get('get_questions','App\Http\Controllers\Api\Customer\UserController@questions');
		Route::get('check_app_update','App\Http\Controllers\Api\Customer\UserController@check_app_update');
		Route::post('answer_question','App\Http\Controllers\Api\Customer\UserController@answer_question');
		Route::post('save_viewed_match_history','App\Http\Controllers\Api\Customer\UserController@save_viewed_match');
		Route::post('save_interest','App\Http\Controllers\Api\Customer\UserController@save_interest');
		Route::get('get_articles','App\Http\Controllers\Api\Customer\UserController@get_articles');
		Route::post('upload_profilePhoto', 'App\Http\Controllers\UserProfileController@uploadProfilePhoto');


		Route::get('sent_interest_list','App\Http\Controllers\Api\Customer\UserController@sent_interestList');
		Route::post('received_interest_list','App\Http\Controllers\Api\Customer\UserController@received_interestList');
		Route::post('blocked_interest_list','App\Http\Controllers\Api\Customer\UserController@blocked_interestList');
		Route::post('change_interest_status','App\Http\Controllers\Api\Customer\UserController@change_interestStatus');
		Route::post('block_interest','App\Http\Controllers\Api\Customer\UserController@block_interest');

		// Matches
		Route::post('get_matches','App\Http\Controllers\Api\Customer\MatchController@matches');
		Route::post('get_saved_profiles','App\Http\Controllers\Api\Customer\MatchController@saved_profiles');
		Route::post('get_profile', 'App\Http\Controllers\Api\Customer\MatchController@user_profile');
		Route::post('search_profiles', 'App\Http\Controllers\Api\Customer\MatchController@search');
		Route::get('refresh_my_matches', 'App\Http\Controllers\Api\Customer\MatchController@refreshMatches');

		Route::post('save_partner_preference', 'App\Http\Controllers\Api\Customer\UserController@savePartnerPreference');
		Route::get('get-partner-preference', 'App\Http\Controllers\Api\Customer\UserController@partnerPreferences');

		// Chat
		Route::post('get_friend_list','App\Http\Controllers\Api\Customer\ChatController@friends');
		Route::post('get_chat_list','App\Http\Controllers\Api\Customer\ChatController@chatList');
		Route::post('send_message','App\Http\Controllers\Api\Customer\ChatController@sendMessage');
		Route::post('update_live_status','App\Http\Controllers\Api\Customer\ChatController@updateLiveStatus');
		Route::post('update_is_online','App\Http\Controllers\Api\Customer\ChatController@updateIsOnline');

		// Subscription
		Route::get('get_subscription_plans','App\Http\Controllers\Api\Customer\SubscriptionController@plans');
		Route::post('purchase','App\Http\Controllers\Api\Customer\OrderController@create');

		Route::post('addToCart','App\Http\Controllers\Api\Customer\CartController@add');
		Route::post('updateCart','App\Http\Controllers\Api\Customer\CartController@update');
		Route::post('deleteCart','App\Http\Controllers\Api\Customer\CartController@delete');
		Route::get('checkout','App\Http\Controllers\Api\Customer\CartController@checkout');
		Route::post('place_order','App\Http\Controllers\Api\Customer\CartController@place_order');

		// NOTIFICATION
		Route::get('notifications','App\Http\Controllers\Api\Customer\NotificationController@list');

		// RATINGS
		Route::post('submitReview','App\Http\Controllers\Api\Customer\RatingController@submit');
    });

	// General Information
    Route::get('get_general_info', 'App\Http\Controllers\Api\Customer\CommonController@general_information');
    Route::get('cms_pages', 'App\Http\Controllers\Api\Customer\CommonController@cms_pages');

    // Common Listing
    Route::post('get_option_list', 'App\Http\Controllers\Api\Customer\OptionController@option_list');
	Route::post('create_option', 'App\Http\Controllers\Api\Customer\OptionController@option_create');
	Route::post('get_option', 'App\Http\Controllers\Api\Customer\OptionController@option_get');
	Route::post('update_option', 'App\Http\Controllers\Api\Customer\OptionController@option_update');

    // COUTRTY, STATE, CITY LIST, LANGUAGE
    Route::get('get_languages', 'App\Http\Controllers\Api\Customer\LanguageController@index');
    Route::get('get_countries', 'App\Http\Controllers\Api\Customer\CountryController@index');
    Route::get('get_states', 'App\Http\Controllers\Api\Customer\StateController@index');
    Route::get('get_cities', 'App\Http\Controllers\Api\Customer\CityController@index');


    // PAYMENT FLOW STATUS
    Route::get('payment-success','App\Http\Controllers\Api\Customer\OrderController@paymet_success');
    Route::get('payment-success-message','App\Http\Controllers\Api\Customer\OrderController@paymet_success_message');
    Route::get('payment-failed','App\Http\Controllers\Api\Customer\OrderController@paymet_failed');
    Route::get('payment-failed-message','App\Http\Controllers\Api\Customer\OrderController@paymet_failed_message');

});
