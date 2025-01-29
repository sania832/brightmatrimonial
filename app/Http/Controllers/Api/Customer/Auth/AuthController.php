<?php

namespace App\Http\Controllers\Api\Customer\Auth;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Authy\AuthyApi;
use Validator,DB;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\SmsVerification;
use App\Models\SmsVerificationNew;
use App\Models\Helpers\CommonHelper;
use App\Models\DeviceDetail;
use App\Models\UserBio;
use App\Http\Resources\BioDataResource;
use App\Http\Resources\AuthUserResource;

class AuthController extends BaseController
{

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //'country_code' => 'required|min:2|max:4',
            'username' => 'required|min:5|max:80',
            'password' => 'required|min:8|max:25',
            'device_type' => 'nullable|in:android,iPhone'
        ]);
        if($validator->fails()){
            return $this->sendValidationError('', $validator->errors()->first());
        }

		DB::beginTransaction();
        try {

			// Check With Mobile
			$auth_check = Auth::attempt(['phone_number' => $request->username, 'password' => $request->password,'user_type'=>'Customer']);
			if(empty($auth_check)){
				// Check With Email
				$auth_check = Auth::attempt(['email' => $request->username, 'password' => $request->password,'user_type'=>'Customer']);
			}

			if($auth_check){
				$user = Auth::user();
				if($user){
					DB::table('oauth_access_tokens')->where('user_id', $user->id)->update([ 'revoked' => true ]);
                }

				$data = $request->except('phone_number','password','user_type','username');
				$createArray = array();

				foreach ($data as $key => $value) {
					$createArray[$key] = $value;
				}

				$device_detail = DeviceDetail::where('user_id',Auth::user()->id)->first();
				if($device_detail){
				    // dd($createArray);
					$device_detail->update($createArray);
					
				} else {
					$createArray['user_id'] = Auth::user()->id;

					DeviceDetail::create($createArray);
				}
				if(strtolower($user->status) == 'inactive') {
					return $this->sendError('',trans('customer_api.login_status_inactive'), 200, 202);
				} else if(strtolower($user->status) == 'blocked') {
					return $this->sendError('',trans('customer_api.login_status_blocked'), 200, 202);
				} else {
					DB::commit();

					//Add response details into variable
					$user->token = $user->createToken(config('constants.APP_NAME'))->accessToken;

					// Get Step Data

					$completed_step = '0';
					$step_data 	= UserBio::where('user_id',$user->id)->first();
					if($step_data){
						if($step_data->step){ $user->completed_step = $step_data->step; }
						$user->bio_data = new BioDataResource($step_data);
					}else{
					    $user->bio_data = new BioDataResource(new UserBio());
					}

					return $this->sendResponse(new AuthUserResource($user), trans('customer_api.login_success'));
				}
			}
			return $this->sendError('',trans('customer_api.login_error'));
		}catch (Exception $e) {
            DB::rollback();
            return $this->sendException($this->object,$e->getMessage());
        }
    }

	/**
	* Logout user (Revoke the token)
	*
	* @return [string] message
	*/
    public function logout(){
        $user = Auth::user();
        /*$device_detail = $user->device_detail;
        if($device_detail){
            $device_detail->delete();
        }*/
        $user->token()->revoke();
        return $this->sendResponse('', trans('customer_api.logout'));
    }


    /**
     * Registration api
     *
     * @return \Illuminate\Http\Response
     */
    public function registration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'	=> 'required|string|min:3|max:33',
            'last_name'    	=> 'required|min:3|max:33',
            'email'     	=> 'required|string|email|max:99|unique:users',
            'gender'       	=> 'required|in:Male,Female,Other',
            'dob' 			=> 'required|date',
            'country_code' 	=> 'required|min:2|max:4',
            'phone_number' 	=> 'required|min:8|max:15|unique:users',
            'profile_for' 	=> 'required|in:Self,Son,Daughter,Relative,Sister,Brother,Client',
            'password'  	=> 'required|min:8|max:16',
        ]);

        if($validator->fails()){
            return $this->sendValidationError('', $validator->errors()->first());
        }

        // EMAIL VALIDATION
        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return $this->sendError('',trans('customer_api.invalid_email'));
        }

        DB::beginTransaction();
        try {

			$data = array(
				'first_name'	=> $request->first_name,
				'last_name'		=> $request->last_name,
				'name'			=> $request->first_name .' '. $request->last_name,
				'email'			=> $request->email,
				'country_code' 	=> $request->country_code,
				'phone_number' 	=> $request->phone_number,
				'profile_for' 	=> $request->profile_for,
				'gender' 		=> $request->gender,
				'dob'       	=> date('Y-m-d', strtotime($request->dob)),
				'status'    	=> 'pending',
				'password'  	=> Hash::make($request->password),
				'user_type' 	=> 'Customer',
			);

			$user = new User();
			$user->fill($data);
            if($user->save()){

                // Save Device Details
                $inputs = $request->except('country_code','phone_number','password','user_type');
                $inputs['user_id'] = $user->id;
                $createArray = array();
                foreach ($inputs as $key => $value) {
                    $createArray[$key] = $value;
                }
                DeviceDetail::create($createArray);
                DB::commit();

                // Send OTP
                // $otp = rand(1000,9999);

				// $message ='Your Verification Code For Bright Matrimonial is '. $otp .'. Thank You, Have a Wonderful Day. Bright Matrimonial Team, brightmatrimonial.com.';
				// CommonHelper::sendOTP($user, $otp, $message);

                //Add response details into variable
                $user->token = $user->createToken(config('constants.APP_NAME'))->accessToken;

                return $this->sendResponse(new AuthUserResource($user), trans('customer_api.registration_success'));
            }else{
                DB::rollback();
                return $this->sendError($this->object,trans('auth.registration_error'));
            }
        }catch (Exception $e) {
            DB::rollback();
            return $this->sendException($this->object,$e->getMessage());
        }

        return $this->sendError('',trans('customer_api.registration_error'));
    }

    /**
     * SEND OTP
     *
     * @return \Illuminate\Http\Response
     */
    public function sendOTP(Request $request){
        $validator = Validator::make($request->all(),[
            'phone_number' => 'required|min:8|max:15',
            'country_code' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendValidationError('',$validator->errors()->first());
        }

        DB::beginTransaction();
        try{
			$user = User::where(['phone_number' => $request->phone_number, 'country_code' => $request->country_code, 'user_type'=>'Customer'])->first();
			if(!empty($user)){
				$otp 		= rand(1000,9999);
				$message 	='Your Verification Code For Bright Matrimonial is '. $otp .'. Thank You, Have a Wonderful Day. Bright Matrimonial Team, brightmatrimonial.com.';
				$sent 		= CommonHelper::sendOTP($user, $otp , $message);
				if($sent){
					DB::commit();
					return $this->sendResponse("", trans('customer_api.otp_sent_success'));
				} else {
					DB::rollback();
					return $this->sendError('', trans('customer_api.otp_sent_error'));
				}
			} else {
				return $this->sendError('', trans('customer_api.otp_sent_error'));
			}
			return $this->sendError('', trans('customer_api.try_again'));
        } catch (\Exception $e) {
          DB::rollback();
          return $this->sendError('', $e->getMessage());
        }
    }

	/**
     * SEND OTP
     *
     * @return \Illuminate\Http\Response
     */
    public function verifyOTP(Request $request){
        $validator = Validator::make($request->all(),[
            'otp' 			=> 'required|min:4|max:4',
            'country_code' 	=> 'required|min:2|max:6',
            'phone_number' 	=> 'required|min:8|max:15',
        ]);

        if($validator->fails()){
            return $this->sendValidationError('',$validator->errors()->first());
        }

        DB::beginTransaction();
        try{
            $dataArray = $request->all();
            $status = SmsVerificationNew::where(array('mobile_number'=>$request->country_code . $request->phone_number, 'code'=>$request->otp, 'status'=>'pending'))->first();
            if(empty($status)){
                return $this->sendError('', trans('customer_api.invalid_otp'));
            }

            $status->status = 'verified';
            $status->update();
            DB::commit();
            return $this->sendResponse("", trans('customer_api.otp_verified_success'));
        } catch (\Exception $e) {
          DB::rollback();
          return $this->sendError('', trans('customer_api.otp_verified_error'));
        }
    }

    /**
     * Active account
     *
     * @return [string] message
     */
    public function active(Request $request){
        $validator = Validator::make($request->all(),[
            'otp' 			=> 'required|min:4|max:4',
            'country_code' 	=> 'required|min:2|max:6',
            'phone_number' 	=> 'required|min:8|max:15'
        ]);

        if($validator->fails()){
            return $this->sendValidationError('',$validator->errors()->first());
        }

        $user = User::where(array('country_code'=>$request->country_code, 'phone_number'=>$request->phone_number))->first();
        if(empty($user)){
            return $this->sendError('', trans('customer_api.no_account_found'));
        }

		if($user->status == 'active'){
			return $this->sendError('', trans('customer_api.already_activeted'));
		}

        DB::beginTransaction();
        try{
            $verify = CommonHelper::verifyOTP($user, $request->otp);
			if(empty($verify)){
                return $this->sendError('', trans('customer_api.invalid_otp'));
            }

			// revoke token
			DB::table('oauth_access_tokens')->where('user_id', $user->id)->update([ 'revoked' => true ]);

            // Update user status
            $user->status = 'active';
            $user->update();
            DB::commit();

			//Set response details into variable
			$user->token = $user->createToken(config('constants.APP_NAME'))->accessToken;
			return $this->sendResponse(new AuthUserResource($user), trans('customer_api.account_act_success'));

        } catch (\Exception $e) {
			echo $e; exit;
			DB::rollback();
			return $this->sendError('', trans('customer_api.account_act_error'));
        }
    }

	/**
	* -----------------------------------
	* FORGOT PASSWORD
	* @return \Illuminate\Http\Response
	*------------------------------------
	**/
    public function forgot_password(Request $request){
        $validator = Validator::make($request->all(),[
            'type' 		=> 'required|min:3|max:15',
            'username' 	=> 'required|min:5|max:55',
        ]);

        if($validator->fails()){
            return $this->sendValidationError('',$validator->errors()->first());
        }

		if($request->type == 'email'){
			$validator = Validator::make($request->all(), [
			  'username'  => 'required|exists:users,email',
			]);
			if($validator->fails()){
			  return $this->sendValidationError('', trans('customer_api.invalid_email'));
			}
		}else if($request->type == 'phone_number'){
			$validator = Validator::make($request->all(), [
			  'username'  => 'required|exists:users,phone_number',
			]);
			if($validator->fails()){
			  return $this->sendValidationError('', trans('customer_api.invalid_mobile_no'));
			}
		}

        DB::beginTransaction();
        try{
			if($request->type == 'email' || $request->type == 'phone_number'){

				// GET USER FROM DATA
				$user = User::where($request->type, $request->username)->first();

				if(!empty($user)){
					$otp = rand(1000,9999);
					$remember_token = md5($otp);
					SmsVerificationNew::create(['mobile_number' => $user->country_code . $user->phone_number,'code' => $otp]);
					$message ='You have made a request for OTP Please Use '. $otp .' to Verify Your Account';

					$sent = CommonHelper::sendOTP($user, $otp, $message);
					if($sent){
						$user->remember_token = $remember_token;
						$user->update();
						DB::commit();
						return $this->sendResponse("", trans('customer_api.otp_sent_success'));
					}else{
						DB::rollback();
						return $this->sendError('', trans('customer_api.otp_sent_error'));
					}
				}
			}
			DB::rollback();
			return $this->sendError('', trans('customer_api.try_again'));

        } catch (\Exception $e) {
          DB::rollback();
          return $this->sendError('', $e->getMessage());
        }
    }
}
