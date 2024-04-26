<?php

namespace App\Http\Controllers\theme;

use Validator,DB,Auth,App;
use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Interested;
use App\Models\Friend;
use App\Models\Chat;
use Illuminate\Support\Facades\Log;

class ChatController extends CommonController
{
	/**
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	* Show the application first page.
	*/
	public function index()
	{
		try {
			$page       	= 'chatPage';
			$page_title 	= trans('title.inbox');
            $interested_list = [];

            $user = Auth::user();

            $inrested_pending = Interested::join('users as t2','t2.id','interested.person_id')
            ->where('interested.person_id',$user->id)->where('interested.status','pending')->pluck('interested.user_id');

            $friend_list = Friend::join('users as t2','t2.id','friends.friend_id')->where('friends.user_id',$user->id)->pluck('friend_id');

            // Merge the arrays and convert to a single unique array
            $userIds = $inrested_pending->merge($friend_list)->unique()->toArray();

            // to update last seen
            $currentTimestamp = date('Y-m-d H:i:s'); // Get the current timestamp
            User::where('id', $user->id)->update(['live_at' => $currentTimestamp]);

            foreach($userIds as $id){

                $in_user = User::find($id);
                $last_chat = Chat::whereIn('user_id', [$user->id, $id])->whereIn('friend_id', [$id, $user->id])->latest('updated_at')->first();

                $lastSeen = "";
                if ($last_chat) {
                    $lastSeenDate = $last_chat->updated_at->toDateString();
                    $todayDate = now()->toDateString();
                    $yesterdayDate = now()->subDays(1)->toDateString();

                    if ($lastSeenDate === $todayDate) {
                        // If last seen is today, display only the time
                        $lastSeen = $last_chat->updated_at->format('H:i');
                    } elseif ($lastSeenDate === $yesterdayDate) {
                        // If last seen is yesterday, display 'Yesterday'
                        $lastSeen = 'Yesterday';
                    } else {
                        // If last seen is before yesterday, display the date
                        $lastSeen = $last_chat->updated_at->format('d/m/Y');
                    }
                }

                $interested_list[] = [
                    'profile_image' => $in_user->profile_image,
                    'name' => $in_user->name,
                    'id' => $in_user->id,
                    'last_seen' => $lastSeen,
                    'last_message' => $last_chat ? $last_chat->message : ""
                ];

            }

			return view('theme.chat.index', compact('page','page_title','interested_list'));
		} catch (Exception $e) {
			return redirect()->back()->withError($e->getMessage());
		}
	}

    public function usersdata($id){

        $user = Auth::user();
        $chat_data = [];
        $chat_user = [];
        $data = [];

        $page       	= 'chatPage';
        $page_title 	= trans('title.inbox');

        if(empty($user)){
            return $this->sendError(trans('customer_api.invalid_user'),'');
        }

        DB::beginTransaction();
		try{
            $details = Interested::where(['person_id'=>$user->id, 'user_id'=>$id])->first();
            $friend = Friend::where(['friend_id'=>$user->id, 'user_id'=>$id])->first();

            // dd($friend);

            if($details || $friend){
                if(isset($details) && $details->status == 'pending'){

                    $chat_user = User::find($id);
                    $status_option = ['accept','reject'];
                    $chat_data = [];

                }elseif(isset($details) && $details->status == 'accept'){

                    $chat_user = User::find($id);
                    $status_option = ['blocked'];
                    $chat_data = [];


                }elseif(isset($details) && $details->status == 'reject'){

                    $chat_user = User::find($id);
                    $status_option = ['accept'];
                    $chat_data = [];
                }
				else{

					$chat_user = User::find($id);
                    $status_option = ['blocked'];
                    $chat_data = [];
				}

                $data = [
                    'chat_user' => $chat_user,
                    'chat_data' => $chat_data,
                    'status_option' => $status_option
                ];

        	}

            return $this->sendResponse(trans('common.received chat data'),$data);

			// return view('theme.chat.index', compact('page','page_title','status_option','chat_data','chat_user'));
		}catch(\Exception $e){
            DB::rollback();
			return redirect()->back()->withError($e->getMessage());
        }
    }

    public function change_interestStatus($status,$id)
    {

        $user = Auth::user();
        if(empty($user)){
            return $this->ajaxError(trans('customer_api.invalid_user'),'');
        }

        DB::beginTransaction();
		try{
			$details = Interested::where(['person_id'=>$user->id, 'user_id'=>$id])->first();
			if($details){
				if($status == 'accept'){

					$data = ['user_id' => $user->id, 'friend_id' => $id];
					$query = Friend::firstOrCreate($data);

					$data2 = ['friend_id' => $user->id, 'user_id' => $id];
					$query2 = Friend::firstOrCreate($data2);

					$query = Interested::where(['user_id'=>$id])->delete();
					if($query){
						DB::commit();
						// $sendArray = [
						// 	'user_id'   => $request->id,
						// 	'title'		=> "Congratulations!",
						// 	'body'		=> "Your request has been accepted by ".$user->name,
						// 	'type'      => "request",
						// 	'createNotification' => true
						// ];

						// $ns = new NotificationService;
						// $ns->sendNotification( $sendArray );
                        return redirect()->back()->with('success', trans('common.saved_success'));
					}

				} else
				if($status == 'reject'){

					$query = Interested::where(['user_id'=>$id])->delete();

					if($query){
						DB::commit();
						return redirect()->back()->with('success', trans('common.saved_success'));
					}
				}
				else{
					$details->fill(['status'=> $status]);
					$return = $details->save();
					if($return){
						DB::commit();

						return redirect()->back()->with('success', trans('common.saved_success'));
					}
				}
			}
			DB::rollback();
			return $this->ajaxError(trans('customer_api.update_error'),'');
		}catch(\Exception $e){
            DB::rollback();
			return $this->ajaxError($e->getMessage(),[]);
        }
    }

    public function sendMessage(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'friend_id'	=> 'required|exists:users,id',
            'message'	=> 'required|min:1|max:999',
        ]);

        if($validator->fails()){
            return $this->ajaxValidationError($validator->errors()->first(),'');
        }

        $user = Auth::user();

		//Get User Data
		if(empty($user)){
			return $this->ajaxError(trans('customer_api.invalid_user'),'');
		}

		DB::beginTransaction();
		try{
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
				return $this->sendArrayResponse(trans('customer_api.sent_success'),$insert);
			}
			return $this->ajaxError(trans('customer_api.sent_failed'),'');
		}catch (\Exception $e) {
			DB::rollback();
			return $this->ajaxError($e->getMessage(),'');
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
			return $this->ajaxError(trans('customer_api.invalid_user'),'');
		}

		if(empty($request->user_id)){
			return $this->ajaxError(trans('customer_api.invalid_friend'),'');
		}

		try{


			// GET LIST
			$chats = Chat::select('chat.*')
                    ->leftJoin('users as t2', 't2.id', '=', 'chat.friend_id')
                    ->whereIn('chat.user_id', [$user->id, $request->user_id])
                    ->whereIn('chat.friend_id', [$request->user_id, $user->id])
                    ->orderBy('chat.created_at', 'asc')
                    ->get();

            // Array to store conversation data
            $conversation = [];

            // Now, you can loop through $chats to populate the conversation array
            foreach ($chats as $chat) {
                // Accessing user details
                $sender = ($chat->user_id == $user->id) ? $user : User::find($chat->user_id);
                $receiver = ($chat->friend_id == $user->id) ? $user : User::find($chat->friend_id);

                // Constructing conversation object
                $conversation[] = [
                    'message' => $chat->message,
                    'sender_name' => $sender->name,
                    'receiver_name' => $receiver->name,
                    'type' => ($chat->user_id == $user->id) ? 'send' : 'receive',
                    'timestamp' => $chat->created_at->format('Y-m-d H:i:s')
                ];
            }

			if(count($conversation)>0){
				return $this->sendArrayResponse( trans('customer_api.data_found_success'),$conversation);
			}
			return $this->sendArrayResponse(trans('customer_api.data_found_empty'),$conversation);

		}catch (\Exception $e) {
			return $this->ajaxError($e->getMessage(),'');
		}
	}

    /**
	* Update Live Status
	* @return \Illuminate\Http\Response
	*/
	// public function updateLiveStatus(Request $request)
	// {
	// 	//Get User Data
	// 	$user = Auth::user();
	// 	if(empty($user)){
	// 		return $this->ajaxError(trans('customer_api.invalid_user'),'');
	// 	}

	// 	DB::beginTransaction();
	// 	try{

	// 		// CREATE
	// 		$update	= User::where('id',$user->id)->update(['live_at' => time()]);
	// 		if($update){
	// 			DB::commit();
	// 			return $this->sendResponse(trans('customer_api.update_success'),[]);
	// 		}
	// 		return $this->ajaxError(trans('customer_api.update_failed'),'');
	// 	}catch (\Exception $e) {
	// 		DB::rollback();
	// 		return $this->ajaxError($e->getMessage(),'');
	// 	}
	// }

}
