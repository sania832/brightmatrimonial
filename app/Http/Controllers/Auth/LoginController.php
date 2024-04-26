<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Authy\AuthyApi;
use DB;
use App\Models\User;
use App\Models\DeviceDetail;
use Session;
use Illuminate\Support\Facades\Log;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class LoginController extends CommonController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
	
	public function loginUser(Request $request){
		$validator = Validator::make($request->all(), [
            'email' 	=> 'required|min:5|max:55',
            'password' 	=> 'required|min:8|max:15',
        ]);
        if($validator->fails()){
            $this->ajaxValidationError(trans('common.error'),$validator->errors());
        }

		$credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials, false)) {

			$user = Auth::user();
			if($user){
				//REVOKE OLD TOKEN
				DB::table('oauth_access_tokens')->where('user_id', $user->id)->update(['revoked' => true]);
				
				// SAVE DEVICE DETAILS
				$deviceArray = [
					'user_id' 	=> $user->id,
					'token' 	=> $user->createToken(config('constants.APP_NAME'))->accessToken,
					'device_token' 	=> '0',
					'device_type' 	=> 'Web'
				];
				DeviceDetail::create($deviceArray);

				$request->session()->regenerate();
				// Session::getHandler()->destroy(Auth::User()->session_id);
				
				Auth::user()->session_id = Session::getId();
				Auth::user()->save();
				//$request->session()->put('data', $user);
			
             }
            return $this->sendResponse(trans('auth.login_success'),[]);
        } else {
			return $this->ajaxError(trans('auth.invalid_credentials'),[]);
		}
	}
}