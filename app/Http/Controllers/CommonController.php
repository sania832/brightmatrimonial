<?php
namespace App\Http\Controllers;

use App;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class CommonController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    //Localization function
    public function lang($locale){
        App::setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }

	// public function ajaxValidationError($message , $result = [], $status= '422'){
	// 	$response = [
	// 		'success'	=> "1",
	// 		'status'	=> $status,
	// 		'message'	=> $message,
	// 		'data' 		=> [],
	// 		'error'		=> $result,
	// 	];
	// 	// echo json_encode($response); exit;
	// 	return response()->json($response);
	// }

	function ajaxValidationError($message,$result = [],$status = '422')
	{
		$response = [
			'success'   => 1,
			'status'    => $status,
			'message'   => $message,
			'data'      => [],
			'error'     => $result,
		];

		return response()->json($response);
	}

	public function ajaxError($message,$result = [],$status = '201'){
		$response = [
			'success'	=> "0",
			'status'	=> $status,
			'message'	=> $message,
			'data' 		=> [],
		];

		if(!empty($result)){
			$response['data'] = $result;
		}

        return response()->json($response);
	}

	public function sendResponse($message,$result = [],$status= '200'){
		$response = [
			'success'	=> "1",
			'status'	=> $status,
			'message'	=> $message,
			'data'	    => $result,
		];

		return response()->json($response);
	}

  public function sendArrayResponse($message , $result = [], $status= '200'){
  	$response = [
		'success'	=> "1",
		'status'  	=> $status,
		'message' 	=> $message,
		'data' 		=> [],
	];

    if(!empty($result)){
      $response['data'] = $result;
    }

	// echo json_encode($response); exit;
    return response()->json($response, 200);
  }
}
