<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
	* Show the application dashboard.
	*
	* @return \Illuminate\Contracts\Support\Renderable
	*/
	public function index(){
		$user = Auth()->user();
        if(empty($user)){ exit('Unauthorized access'); }
		// dd($user);
        if($user->user_type == 'superAdmin'){
            $page_title = trans('admin.dashboard');

			// counts
            $users = User::count();
            return view('admin.dashboard',compact('page_title','users'));

        }else if($user->user_type == 'Vendor'){
			return redirect()->route('vendorDashboard');

		} else{
            return redirect()->route('firstPage');
        }
    }

	public function dashboard(){
		return redirect()->route('home');
    }
}
