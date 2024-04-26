<?php

namespace App\Http\Controllers\Api\Customer;

use Validator;
use DB,Settings;
use Authy\AuthyApi;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController;
use App\Models\Helpers\CommonHelper;
use App\Models\User;
use App\Models\Chat;
use App\Models\Friend;

use App\Http\Resources\ChatListResource;
use App\Http\Resources\FriendListResource;

class ChatController extends BaseController
{
	/**
	* Friend List
	* @return \Illuminate\Http\Response
	*/
	public function friends(Request $request)
	{
		$search = $request->search;
        $page   = $request->page ?? 1;
        $count  = $request->count ?? '100';

        if ($page <= 0){ $page = 1; }
        $offset = $count * ($page - 1);

		//Get User Data
		$user = Auth::user();
		if(empty($user)){
			return $this->sendError('',trans('customer_api.invalid_user'));
		}

		try{

			// dd("UserId",$user->id, "FriendId",Friend::select('t2.*')->join('users as t2', 't2.id', '=', 'friends.friend_id')->get() );
			// GET LIST
			$query = Friend::select('t2.*')->join('users as t2', 't2.id', '=', 'friends.friend_id')->where('friends.user_id', '=', $user->id)
                    ->orderBy('friends.id', 'DESC')->offset($offset)->limit($count)->get();

			//$query = Friend::where('user_id', '!=', $user->id)->orderBy('id','DESC')->offset($offset)->limit($count)->get();
			if(count($query)>0){
				return $this->sendArrayResponse(FriendListResource::collection($query), trans('customer_api.data_found_success'));
			}
			return $this->sendArrayResponse([], trans('customer_api.data_found_empty'));

		}catch (\Exception $e) {
			return $this->sendError('', $e->getMessage());
		}
	}

	/**
	* Chat List
	* @return \Illuminate\Http\Response
	*/
	public function chatList(Request $request)
	{
		$search = $request->search;
        $page   = $request->page ?? 1;
        $count  = $request->count ?? '100';

        if ($page <= 0){ $page = 1; }
        $offset = $count * ($page - 1);

		//Get User Data
		$user = Auth::user();
		if(empty($user)){
			return $this->sendError('',trans('customer_api.invalid_user'));
		}

		if(empty($request->friend_id)){
			return $this->sendError('',trans('customer_api.invalid_friend'));
		}

		try{
			// GET LIST
			$query = Chat::select('chat.*')
					->rightJoin('users as t2', 't2.id', '=', 'chat.user_id')
					->whereIn("chat.user_id", [$user->id, $request->friend_id])
					->whereIn("chat.friend_id", [$request->friend_id, $user->id])
					->orderBy('chat.id','DESC')->offset($offset)->limit($count)->get();
			if(count($query)>0){
				return $this->sendArrayResponse(ChatListResource::collection($query), trans('customer_api.data_found_success'));
			}
			return $this->sendArrayResponse([], trans('customer_api.data_found_empty'));

		}catch (\Exception $e) {
			return $this->sendError('', $e->getMessage());
		}
	}

	/**
	* Send Message
	* @return \Illuminate\Http\Response
	*/
	public function sendMessage(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'friend_id'	=> 'required|exists:users,id',
            'message'	=> 'required|min:1|max:999',
        ]);
        if($validator->fails()){
            return $this->sendValidationError('', $validator->errors()->first());
        }

		//Get User Data
		$user = Auth::guard('api')->user();
		if(empty($user)){
			return $this->sendError('',trans('customer_api.invalid_user'));
		}

		DB::beginTransaction();
		try{
			$token = Auth::guard('api')->user();
			// CREATE
			$insert	= Chat::create(['user_id'=>$user->id, 'friend_id'=>$request->friend_id, 'message'=>$request->message]);
			if($insert){
				DB::commit();

				//notify user
				$sendArray = [
				'user_id'                       => $request->friend_id,
				'body'							=> $request->message,
				'title'							=> "New message from ".$user->name,
				'createNotification'		    => true,
				];
				// $ns = new NotificationService;
				// $ns->sendNotification($sendArray);
				// CommonHelper::send_notification($user = '', $title = '', $message = '', 'msj')
				return $this->sendResponse($insert, trans('customer_api.sent_success'));
			}
			return $this->sendError('', trans('customer_api.sent_failed'));
		}catch (\Exception $e) {
			DB::rollback();
			return $this->sendError('', $e->getMessage());
		}
	}

	/**
	* Update Live Status
	* @return \Illuminate\Http\Response
	*/
	public function updateLiveStatus(Request $request)
	{
		//Get User Data
		$user = Auth::user();
		if(empty($user)){
			return $this->sendError('',trans('customer_api.invalid_user'));
		}

		DB::beginTransaction();
		try{
			// CREATE
            $currentDateTime = date('Y-m-d H:i:s');
			$update	= User::where('id',$user->id)->update(['live_at' => $currentDateTime]);
			if($update){
				DB::commit();
				return $this->sendResponse([], trans('customer_api.update_success'));
			}
			return $this->sendError('', trans('customer_api.update_failed'));
		}catch (\Exception $e) {
			DB::rollback();
			return $this->sendError('', $e->getMessage());
		}
	}

	/**
	* Update Online / Offline Status
	* @return \Illuminate\Http\Response
	*/
	public function updateIsOnline(Request $request)
	{
		$request->validate([
		'status' => 'integer|between:0,1'
		]);

		//Get User Data
		$user = Auth::user();
		if(empty($user)){
			return $this->sendError('',trans('customer_api.invalid_user'));
		}

		DB::beginTransaction();
		try{
			// CREATE
			$update	= User::where('id',$user->id)->update(['isOnline' => $request->status]);
			if($update){
				DB::commit();
				return $this->sendResponse([], trans('customer_api.update_success'));
			}
			return $this->sendError('', trans('customer_api.update_failed'));
		}catch (\Exception $e) {
			DB::rollback();
			return $this->sendError('', $e->getMessage());
		}
	}
}
