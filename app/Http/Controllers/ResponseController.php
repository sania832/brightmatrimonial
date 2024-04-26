<?php
namespace App\Http\Controllers;

use App;
use App\Http\Controllers\Controller as Controller;

class ResponseController extends Controller
{
    /**
     *
     * @return void
     *
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

   public function ajaxValidationError($result = [], $message, $status= '422'){
  	$response = [
		'success'	=> "1",
		'status'	=> $status,
		'message'	=> $message,
		'data' 		=> [],
		'error'		=> $result,
	];
	echo json_encode($response); exit; 
	//return response()->json($response);
  }
  
   public function ajaxError($result = [], $message, $status = '201'){
	$response = [
		'success'	=> "0",
		'status'	=> $status,
		'message'	=> $message,
		'data' 		=> [],
	];
	echo json_encode($response); exit; 
	//return response()->json($response);
  }
  
  public function sendResponse($result = [], $message, $status= '200'){
    $response = [
		'success'	=> "1",
		'status'	=> $status,
		'message'	=> $message,
		'data'	=> [],
    ];
    if(!empty($result)){
      $response['data'] = $result;
    }
	echo json_encode($response); exit;
	//return response()->json($response);
  }

  public function sendArrayResponse($result = [], $message, $status= '200'){
  	$response = [
		'success'	=> "1",
		'status'  	=> $status,
		'message' 	=> $message,
		'data' 		=> [],
	];

    if(!empty($result)){
      $response['data'] = $result;
    }
	echo json_encode($response); exit;
    //return response()->json($response, 200);
  }
}
