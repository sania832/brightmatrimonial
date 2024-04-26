<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\CommonController;
use App\Models\User;
use App\Models\Helpers\CommonHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\RegistersUsers;
use Exception;
use Illuminate\Support\Facades\Log;

class RegisterController extends CommonController
{
    use RegistersUsers;

    protected $redirectTo = 'admin/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $is_vendor	 = $request->is_vendor ? 1 : 0;
		$user_tyle	 = 'Customer';

        $validator = Validator::make($request->all(), [
            'first_name'    => 'required|max:51',
            'last_name'     => 'required|max:51',
            'email'         => 'required|email|string|min:4|max:99|unique:users',
            'country_code'  => 'required|min:2|max:6',
            'phone_number'  => 'required|min:8|max:15|unique:users',
            'profile_for'   => 'required|string|min:3|max:99',
            'gender'        => 'required|string|min:3|max:6',
            'day'           => 'required|numeric|min:1|max:31',
            'month'         => 'required|numeric|min:1|max:12',
            'year'          => 'required|numeric|min:1980|max:2010',
            'password'      => 'required|min:8|max:16|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->ajaxValidationError(trans('common.error'), $validator->errors());
        }

        DB::beginTransaction();
        try {
            // USER REGISTER
			$insertData = [
				'first_name'		=>$request->first_name,
				'last_name'			=>$request->last_name,
				'name'				=>$request->first_name .' '. $request->last_name,
				'email'				=>$request->email,
				'country_code'		=>$request->country_code,
				'phone_number'		=>$request->phone_number,
				'profile_for'		=>$request->profile_for,
				'user_type'			=>$user_tyle,
				'gender'			=>$request->gender,
                'dob'               => $request->year . '-' . $request->month . '-' . $request->day,
				'email_verified_at'	=>date('Y-m-d h:i:s'),
				'password'			=>Hash::make($request->password)
			];
			$user = User::create($insertData);

            if ($user) {
                DB::commit();

				// Also Login
				$return = Auth::guard('web')->login($user);

				$credentials = $request->only('email', 'password');
				if (Auth::guard('web')->attempt($credentials, false)) {
					$request->session()->put('data', $user);
				}

				$response = [
                  'success' => "1",
                  'status'  => "200",
                  'message' => trans('common.register_success'),
                  'html' => trans('common.verify_account'),
                  'data'  => $user
                ];

				// Send Mail
				// $otp = rand(1000,9999);
				// $message ='You have made a request for OTP Please Use '. $otp .' to Verify Your Account';
				// CommonHelper::sendOTP($otp,$user,$message);

                return $this->sendResponse(trans('common.register_success'),[]);
			}

			DB::rollback();
			$this->ajaxError(trans('common.try_again'),[]);

		} catch (Exception $e) {
            DB::rollback();
            $this->ajaxError(trans('common.try_again'),[]);
        }
    }
}
