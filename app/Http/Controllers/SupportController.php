<?php

namespace App\Http\Controllers;
use App\Models\DeviceDetail;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Auth;

class SupportController extends Controller
{
	/*
	 *----------------------
	 * Clear Cache
	 *----------------------
	*/
	public function clear_cache(){
		Artisan::call('config:clear');
		echo 'Config cleared </br>';
		Artisan::call('route:clear');
		echo 'Route cleared </br>';
		Artisan::call('cache:clear');
		echo 'Cache cleared </br>';
		Artisan::call('view:clear');
		echo 'View cleared </br>';
    }
	
	/*
	 *----------------------
	 * Create Cache
	 *----------------------
	*/
	public function caches(){
		Artisan::call('config:cache');
		echo 'Config cached </br>';
		Artisan::call('route:cache');
		echo 'Route cached </br>';
		Artisan::call('optimize');
		echo 'Optimize';
    }
	
	/*
	 *----------------------
	 * Run Migration
	 *----------------------
	*/
	public function migration(){
		Artisan::call('migrate');
		return "Migrate run successfully!!";
    }
	
	/*
	 *----------------------
	 * Run Database Seeder
	 *----------------------
	*/
	public function seeding(){
		Artisan::call('db:seed');
		return "Seeder run successfully!!";
    }
	
	/*
	 *----------------------
	 * Send Test Notification
	 *----------------------
	*/
	public function test_notification($to = '', $senderId = '')
	{
		if(empty($to)){
			echo '<p>Error: ID required</p>'; exit;
		} 
		$user = DeviceDetail::where("user_id", $to)->get()->first(); 
		$sender = User::where("id", $senderId)->get()->first();
		$sendArray = [
		   "to" => $user->device_token, 
		   "notification" => [
				 "body" => "body",
				 "title" => "hello ". (rand(1,1111)),
			  ], 
		   "data" => [
				 "type" => "msj", //request, msg, request-accept
				 "name" => $sender->name,
				 "id" => $sender->id,
				 "image" => $sender->profile_image,
				 ] 
		]; 
		 
		
		$headers = array (
            'Authorization: key=' . "AAAADRx9G3Y:APA91bEagnR-yefMp1W0MmPGtjnQydlx2VXAhTrABwnXgVU-t0eEmZOvFtWJDzNfZ0_kyo7juUtLs-tJNamEDPcf7raRU6NnVf6Ifig5638fags82ZflypN0rmeDiAPMNQ5pj1fDo06Z",
            'Content-Type: application/json'
    	);
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($sendArray));
		$result = curl_exec($ch);
		//$result = json_decode(curl_exec($ch), TRUE);
		
		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch); exit;
		}
	
		curl_close ($ch);
		
		
		// echo '<b>Payload :</b><br>';
		// echo json_encode($sendArray2);
		echo $result;
		// echo '<br><br><br><br><hr><b>Return Response:</b><br>';
		
		// echo'<pre>'; print_r($result);
    }
}
