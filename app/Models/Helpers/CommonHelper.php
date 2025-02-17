<?php

namespace App\Models\Helpers;

use Illuminate\Support\Facades\Storage;
use DB;
use App\Models\Notification;
use App\Models\SmsVerificationNew;
use App\Models\Subscription;
use Illuminate\Support\Facades\Log;

trait CommonHelper
{
    //public variables
    public $media_path = 'uploads/';


	/**
	* GET Directory
	*/
	public function get_upload_directory($folder = ''){
	    $year 	= date("Y");
		$month 	= date("m");
		$folder = $folder ? $folder . '/' : '';

		$media_path1 = public_path($this->media_path . $folder . $year.'/');
		$media_path2 = public_path($this->media_path . $folder . $year .'/'. $month.'/');
		$media_path3 = $this->media_path . $folder . $year .'/'. $month.'/';

		if(!is_dir($media_path1)){
			mkdir($media_path1, 0755, true);
		}
		if(!is_dir($media_path2)){
			mkdir($media_path2, 0755, true);
		}
		return $media_path3;
	}

	/**
	* Save different type of media into different folders
	*/
	public function saveMedia($file, $folder = '',  $type = '', $width = '', $height = ''){

		if(empty($file)){ return; }

		$upload_directory 	= $this->get_upload_directory($folder);
		$name 				= md5($file->getClientOriginalName() . time() . rand());
		// $extension 			= $file->getClientOriginalExtension();
        $extension          = $file->guessExtension();
		$fullname 			= $name . '.' . $extension;
		$thumbnail 			= $name .'150X150.'. $extension;
		// CREATE THUMBNAIL IMAGE
		// $img = Image::make(public_path($fullname))->resize(150, 150)->insert(public_path($thumbnail));

        if($type == ''){
			$file->move(public_path($upload_directory),$fullname);
            return $upload_directory . $fullname;
        } else if($type == 'image'){
            DB::beginTransaction();
            try{
                $path = Storage::disk('s3')->put('images/originals', $file,'data/public');
                DB::commit();

                return $path;
            } catch(\Exception $e){
                DB::rollback();
                $path = '-';

                return $path;
            }
        } else {
            return false;
        }
    }

	// PAYMENT GATEWAY CREATE ORDER
	public static function gateway_create_order($data = array()){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_USERPWD, 'rzp_test_7EpAOUQqF7fvt3' . ':' . 'CpnLv6qcK0cNePHCSRsqn6gy');
		curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/orders');
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // On dev server only!
		$posts_result = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        return $posts_result;
	}

	// PAYMENT CONFIRM ORDER
	public static function gateway_confirm_order($data = array()){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_URL, 'https://services.ameriabank.am/VPOS/api/VPOS/InitPayment');
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // On dev server only!
		$posts_result = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        return $posts_result;
	}

	// After Order Payment Success Run this Function
	public static function order_finalization($order_id = 0, $user = []){

		$payment_method	= 'Cash';
		$templateItems 	= [];

		// GET ORDER DATA
		$order_data = Order::where(['id'=>$order_id])->first();
		if($order_data){

			// GET Order Items
			$order_items = OrderItem::where(['order_id'=>$order_data->id])->get();
			foreach($order_items as $key=> $list){

				// validate Items
				$product = Product::where(['id'=> $list->product_id])->first();
				if(!empty($product)){
					$templateItems[] = [
					  'image' => $product->image ? asset('public/'. $product->image) : asset('public/'.env("DEFAULT_IMAGE")),
					  'title' => $product->title,
					  'price' => $product->price,
					];
				}
			}

			// Delete existing cart
			Cart::where(['user_id'=> $user->id])->delete();

			$order_data->status = 'Received';
			if($order_data->payment_method_id == 2){
				$payment_method	= 'Card';
				$order_data->payment_status = '1';
			}
            $order_data->update();
            DB::commit();

			// send SMS
			$message = trans('customer_api.dear'). ' '. $user->name .',\r\n '. trans('customer_api.your_order_has_been_successfully_created') .'\r\n'. trans('customer_api.thank_you_for_choosing_amen_inch');
			CommonHelper::sendMessage($user->country_code. $user->phone_number, $message);


			// Send Push Notification
			$message = trans('customer_api.you_have_new_order_from_customer') .' '. $user->name;
			$restaurant = User::where('id', $order_data->owner_id)->first();
			CommonHelper::send_notification($restaurant, 'New Order', $message, '1', $order_id, $order_data);


			// send Mail
			$template_data = new \stdClass();
			$template_data->user				= $user;
			$template_data->date				= date('F d, Y');
			$template_data->time				= date('h: i');
			$template_data->order_id			= $order_id;
			$template_data->order_items			= $templateItems;
			$template_data->restaurant_logo		= $order_data->restaurant->image ? asset('data/public/'. $order_data->restaurant->image) : '';
			$template_data->shipping_address	= $order_data->shipping_address;
			$template_data->shipping_charge		= $order_data->shipping_charge;
			$template_data->payment_method 		= $payment_method;
			$template_data->total				= $order_data->total;
			$template_data->grand_total			= $order_data->grand_total;
			$template_data->delivery_fee		= '0.00';

			CommonHelper::sendMail($user->email, 'Order created Successfully', 'email-templates.create-order-customer', $template_data);
		}
	}

	// Active Subscription
	public static function saveSubscription($user, $array = [])
	{
		// GET DATA
		$data = Subscription::where(['user_id'=>$user->id])->first();
		if($data){
			$data->order_id = $data['order_id'];
			$data->plan_id = $data['plan_id'];
			$data->package_id = $data['package_id'];
			$data->expiry_date = $data['expiry_date'];
			$query = $data->update();
			if($query){
				DB::commit();
				return $query;
			}
		}else{
			$query = Subscription::create($array);
			if($query){
				DB::commit();
				return $query;
			}
		}
	}

	// SEND OTP
	public static function sendOTP($otp ,$user = [], $message = '')
	{
		try {
			// send SMS
			CommonHelper::sendMessage($user->country_code. $user->phone_number, $message);

			// Insert Record also
			SmsVerificationNew::create(['mobile_number' => $user->country_code . $user->phone_number,'code' => $otp]);
			$to = $user->country_code. $user->phone_number;

			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.msg91.com/api/v5/otp?template_id=61ab49f114e1f65cbe357ac6&mobile=$to&authkey=307618AjQP6pIk5dee1286",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array("content-type: application/json"),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
			  return false;
			} else {
			  return 1;
			}

			// send Mail
			$template_data = new \stdClass();
			$template_data->user				= $user;
			$template_data->date				= date('F d, Y');
			$template_data->time				= date('h: i');
			$template_data->message				= $message;
			$template_data->otp					= $otp;
			CommonHelper::sendMail($template_data , $user->email, 'OTP', 'email-templates.otp');

			return 1;
		} catch (Exception $e) {
			return false;
		}
	}

	// SEND OTP
	public static function verifyOTP($otp , $user = [])
	{
		try {
			$to = $user->country_code. $user->phone_number;
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://api.msg91.com/api/verifyRequestOTP.php?authkey=307618AjQP6pIk5dee1286&mobile=$to&otp=$otp",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array("content-type: application/json"),
			));
			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
			  return false;
			} else {
			  return 1;
			}
		} catch (Exception $e) {
			return false;
		}
	}

	// SENT Whatsapp OTP
	public static function sentWOTP($otp, $user = [], $message = ""){
		try {
			$to = $user->country_code . $user->phone_number;
			$api_url = "https://live-mt-server.wati.io/399656/api/v1/sendTemplateMessage?whatsappNumber=$to";
			$authorization = "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiJjODI0N2E1OS1iNjMzLTQyYzQtYTFlNi04ZTZkOGQzYmRhN2EiLCJ1bmlxdWVfbmFtZSI6InRvbm55QHRyaW9lbmN5LmNvbSIsIm5hbWVpZCI6InRvbm55QHRyaW9lbmN5LmNvbSIsImVtYWlsIjoidG9ubnlAdHJpb2VuY3kuY29tIiwiYXV0aF90aW1lIjoiMDIvMDYvMjAyNSAwODo1NjozMiIsInRlbmFudF9pZCI6IjM5OTY1NiIsImRiX25hbWUiOiJtdC1wcm9kLVRlbmFudHMiLCJodHRwOi8vc2NoZW1hcy5taWNyb3NvZnQuY29tL3dzLzIwMDgvMDYvaWRlbnRpdHkvY2xhaW1zL3JvbGUiOiJBRE1JTklTVFJBVE9SIiwiZXhwIjoyNTM0MDIzMDA4MDAsImlzcyI6IkNsYXJlX0FJIiwiYXVkIjoiQ2xhcmVfQUkifQ.EOz_OcLuDeAOlg29MhqFC3N7tH9zYrY7pnKajT3X7zQ";

			// JSON data
			$data = json_encode([
				"template_name" => "otp",
				"broadcast_name" => "otp",
				"parameters" => [
					[
						"name" => "1",
						"value" => $otp
					]
				]
			]);

			$curl = curl_init();
			curl_setopt_array($curl, [
				CURLOPT_URL => $api_url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => $data,
				CURLOPT_HTTPHEADER => [
					"accept: */*",
					"Authorization: $authorization",
					"Content-Type: application/json"
				],
			]);

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);

			if ($err) {
				return false;
			} else {
				// Store OTP in SmsVerificationNew

				return 1;
			};
		} catch (Exception $e) {
			return false;
		}
	}

	// Verify OTP
	public static function verifyWOTP($otp, $user = []){

	}

	//SEND MESSAGE
	public static function sendMessage($to, $message = ""){
		if(empty($to)){ return; }
		if(empty($message)){ return; }
		try {

			$postData = array(
				'authkey' => '307618AjQP6pIk5dee1286',
				'mobiles' => $to,
				'message' => urlencode($message),
				'sender' => 'BRTMNL',
				'route' => 'default'
			);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"http://api.msg91.com/api/sendhttp.php");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$postData);  //Post Fields
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($ch);
			curl_close ($ch);
			return $server_output;


		} catch (Exception $e) {
			return false;
		}
	}

	//SEND MAIL
	public static function sendMail($template_data, $email = '', $subject = '', $template = ''){
		$data = array('email'=>$email,'subject'=>$subject, 'template_data'=>$template_data);

		try {
			$url = 'https://api.sendgrid.com/v3/mail/send';
			$body = view($template, compact('template_data'))->render();
			$authorization = "Authorization: Bearer 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";
			//$authorization = "Authorization: Bearer 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";

			$data = array (
			  'personalizations' => array (0 => array ('to' => array (0 => array ('email' => $email,),),),),
			  'from' => array ('name' => 'amen inch','email' => 'noreply@amen-inch.com',),
			  'subject' => $subject,
			  'content' => array (0 => array ('type' => 'text/html','value' => $body,),),
			);
			$postdata = json_encode($data);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_TIMEOUT, 80);
			$response = curl_exec($ch);

			if(curl_error($ch)){
				$return = false;
			} else{
				$return = $response;
			}
			curl_close($ch);
			return $return;
		} catch (Exception $e) {
			return false;
		}
	}

	// SEND MOBILE NOTIFICATION
	public static function send_notification($user = '', $title = '', $message = '', $type = '', $type_id = '', $data = ''){
		$fcm_server_key   = Setting::get('fcm_server_key');
		$token          = ($user->device_detail) ? $user->device_detail->device_token : '';
		//$token            = 'dusZDI_7RQCEWS5CfWoQOd:APA91bFPMFMzz-8TppDEmwcZ4wFkX9lb_4oItCtG9nma5gFx6MIYF6TiXeyrmWc0JQpAmSNym61wWC0ZCwLqMJwfpuOYWGqQ9jJ5kW2gfu8TyPg6OvwxALkr5jca0bqG75eyBbyI76z-';

		$data = [
		  "user_id"   		=> (string) $user->id,
		  "type"      		=> (string) $type,
		  "type_id"   		=> (string) $type_id,
		  "date_time" 		=> date('Y-m-d H:i:s'),
		  "click_action" 	=> 'FLUTTER_NOTIFICATION_CLICK',
		  "sound" 			=> 'default',
		  "status" 			=> 'done',
		  "screen" 			=> 'screenA',
		  "title" 			=> $title,
		  "body" 			=> $message,
		];

		try {
		  $insert = Notifications::create($data);
		  if($insert){
			if($insert->id && $token){
			  $data['notification_id'] = (string) $insert->id;

			  $sendArray__ = [
				"notification" => ["title"=>$title,"body"=>$message],
				"data"=>$data,
				"to" => $token,
			  ];

			  $sendArray = [
					"to" => $token,
					"notification" => [
						"body" => $message,
						"title" => $title,
					],
					"android" => [
						"priority" => "high",
					],
					"apns" => [
						"headers" => ["apns-priority" => "10",],
						"payload" => ["aps" => ["sound" => "default",],],
					],
					"data" => [
						"click_action" => "FLUTTER_NOTIFICATION_CLICK",
						"sound" => "default",
						"content_available" => true,
						"mutable_content" => true,
					],
			  ];

			  $headers = array ( 'Authorization: key=' . $fcm_server_key, 'Content-Type: application/json' );
			  $ch = curl_init(); curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
			  curl_setopt( $ch,CURLOPT_POST, true );
			  curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
			  curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			  curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($sendArray));
			  $result = json_decode(curl_exec($ch), TRUE);
			  curl_close ($ch);
			  if(!empty($result) && $result['success'] == 1){
				$insert->is_sent = 1;
				$insert->update();
				return $result;
			  }else{
				return FALSE;
			  }
			}
		  }
		} catch (\Exception $e) {
		  return FALSE;
		}
	}
}
