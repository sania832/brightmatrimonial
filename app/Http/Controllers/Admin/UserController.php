<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Helpers\CommonHelper;
use Validator, Auth, DB, Storage;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\UserBio;
use App\Models\Country;
use App\Models\Option;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends CommonController
{
  use CommonHelper;
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
    // $this->middleware('permission:restaurant-list', ['only' => ['index','show']]);
    // $this->middleware('permission:restaurant-create', ['only' => ['create','store']]);
    // $this->middleware('permission:restaurant-edit', ['only' => ['edit','update']]);
    // $this->middleware('permission:restaurant-delete', ['only' => ['destroy']]);
  }

	// List of restaurants
	public function index()
	{
		return view('admin.users.list');
	}

	// CREATE
	public function create()
	{
		$page_title      = '';
		$country     = Country::where('status', 'active')->get();
		$categories   = Category::where('status', 'active')->get();
		return view('admin.users.add', compact('page_title', 'country', 'categories'));
	}

	public function edit($id = null)
	{
		try
		{
			$user = Auth()->user();
			if (empty($user)) {
			$this->ajaxError(trans('common.invalid_user'),[]);
			}

			// GET DATA
			$data		=  User::where('id', $id)->first();
			$user_bio	=  UserBio::where('user_id', $id)->first();
            
            $user_details = [
                'religion' => Option::where('type','religion')->where('id',$user_bio->religion)->pluck('title')->first(),
                'community' => Option::where('type','community')->where('id',$user_bio->community)->pluck('title')->first(),
                'mother_tongue' => Option::where('type','mother_tongue')->where('id',$user_bio->mother_tongue)->pluck('title')->first(),
                'city' => City::where('id',$user_bio->city)->pluck('name')->first(),
                'marital_status' => Option::where('type','marital_status')->where('id',$user_bio->marital_status)->pluck('title')->first(),
                // 'diet' => Option::where('type','diet')->where('id',$user_bio->diet)->pluck('title')->first(),
                'height' => Option::where('type','height')->where('id',$user_bio->height)->pluck('title')->first(),
                'position' => Option::where('type','company_position')->where('id',$user_bio->position)->pluck('title')->first(),
                'cast' => Option::where('type','cast')->where('id',$user_bio->cast)->pluck('title')->first(),
                'sub_cast' => Option::where('type','sub_cast')->where('id',$user_bio->sub_cast)->pluck('title')->first(),
                'family_type' => Option::where('type','family_type')->where('id',$user_bio->family_type)->pluck('title')->first(),
                'father_occupation' => Option::where('type','father_occupation')->where('id',$user_bio->father_occupation)->pluck('title')->first(),
                'family_living_in' => City::where('id',$user_bio->family_living_in)->pluck('name')->first(),
                'document_type' => ($user_bio->document_type == 1) ? 'Pancard' : (($user_bio->document_type == 2) ? 'Votercard' : 'Driving license')
            ];

            // dd($user_details);

			return view('admin.users.edit', compact('data','user_bio','user_details'));

		} catch (Exception $e) {
			return redirect()->route('vendorDashboard')->with('error', $e->getMessage());
		}
	}

	// Update User
	public function update(Request $request)
	{
        $user = Auth()->user();
		if(empty($user)){
			$this->ajaxError(trans('common.unauthorized_access'),[]);
		}

		// CREATE VALIDATION CHECKS
		$validator = Validator::make($request->all(), [
			'first_name'		=> 'required|min:2|max:51',
			'last_name'		 	=> 'required|min:2|max:51',
			'dob'		 		=> 'required|min:5|max:51',
			'email'				=> ['required', 'email', 'max:51', Rule::unique('users')->ignore($user->id)],
			//'phone_number'	=> 'required|numeric|unique:users',
		]);
		if ($validator->fails()) {
			return $this->ajaxValidationError(trans('common.error'),$validator->errors());
		}

        try {

		$data = [
			'first_name'	=> $request->first_name,
			'last_name'		=> $request->last_name,
			'dob'			=> $request->dob,
			'email'			=> $request->email,
		];

		$return = User::where('id',$user->id)->update($data);
		if($return){
            Log::info('store data succefully');
			return $this->sendResponse(trans('common.update_success'),[]);
		}
		} catch (Exception $e) {
			$this->ajaxError($e->getMessage(),[]);
		}
	}

  // STORE
  public function store(Request $request)
  {

    if (empty($request->item_id)) {
      // CREATE VALIDATION CHECKS
      $validator = Validator::make($request->all(), [
        'title_en'           => 'required|min:3|max:99',
        'email'              => 'required|email|max:50|unique:users',
        'phone_number'       => 'required|numeric|unique:users',
        'password'           => 'required',
        'address_en'         => 'required|min:3|max:1000',
        // 'flat_discount'      => 'required|numeric|min:1|max:100',
        'zip_code'           => 'required|numeric',
        'city_id'            => 'required|numeric',
        'state_id'           => 'required|numeric',
        'country_id'         => 'required|numeric',
        'categories'         => 'required',
        'status'             => 'required',
        'latitude'           => 'required',
        'longitude'          => 'required',
        'status'             => 'required',
      ]);
      if ($validator->fails()) {
        return $this->ajaxValidationError(trans('common.error'),$validator->errors());
      }

      // UPDATE VALIDATION CHECKS
    } else {
      $restaurant = Restaurant::find($request->item_id);
      $validator = Validator::make($request->all(), [
        'item_id'            => 'required',
        'title_en'           => 'required|min:3|max:99',
        'email'              =>  ['required', 'max:99', Rule::unique('restaurants')->ignore($restaurant->id)],
        'phone_number'       =>  ['required', 'numeric', Rule::unique('restaurants')->ignore($restaurant->id)],
        // 'password'           => 'required',
        'address_en'         => 'required|min:3|max:1000',
        // 'flat_discount'      => 'required|numeric|min:1|max:100',
        'zip_code'           => 'required|numeric',
        'city_id'            => 'required|numeric',
        'state_id'           => 'required|numeric',
        'country_id'         => 'required|numeric',
        'categories'         => 'required',
        'status'             => 'required',
        'latitude'           => 'required',
        'longitude'          => 'required',
        'status'             => 'required',
      ]);
      if ($validator->fails()) {
        return $this->ajaxValidationError(trans('common.error'),$validator->errors());
      }
    }

    DB::beginTransaction();
    try {
      $userdata = [
        'name'              => $request->title_en,
        'email'             => $request->email,
        'password'          => Hash::make($request->password),
        'phone_number'      => $request->phone_number,
        'user_type'         => 'Vendor',
        'status'            => $request->status,
        'vendor_approved'   => '1',
        'email_verified_at' => date('Y-m-d h:i:s'),
      ];

      if ($request->item_id) {
        // UPDATE USER
        $user        =  User::find($restaurant->owner->id);
        $user_update        =  $user->update($userdata);
      } else {
        // CREATE USER
        $user = User::create($userdata);
        $user->assignRole('Vendor');
      }
      if ($user) {
        $restaurants = [
          'owner_id'              => $user->id,
          'title:en'              => $request->title_en,
          'phone_number'          => $request->phone_number,
          'email'                 => $request->email,
          'country_id'            => $request->country_id,
          'latitude'              => $request->latitude,
          'longitude'             => $request->longitude,
          'zip_code'              => $request->zip_code,
          'city_id'               => $request->city_id,
          // 'categories'            => $request->categories,
          'state_id'              => $request->state_id,
          'country_id'            => $request->country_id,
          'flat_discount'         => $request->flat_discount,
          'address:en'            => $request->address_en,
          'user_type'             => 'Vendor',
          'status'                => $request->status,
          'vendor_approved'       => '1',
          'email_verified_at'     => date('Y-m-d h:i:s'),
        ];
        // SAVE IMAGES AND BANNER
        if ($request->image != "undefined") {
          // if(file_exists($restaurants->image)){
          //   unlink($restaurants->image);
          // }
          $path = $this->saveMedia($request->file('image'));
          $restaurants['image'] = $path;
        }
        if ($request->banner_image != "undefined") {
          // if(file_exists($restaurant->banner_image)){
          //   unlink($restaurant->banner_image);
          // }
          $banner_img_path = $this->saveMedia($request->file('banner_image'));
          $restaurants['banner_image'] = $banner_img_path;
        }

        // UPDATED RESTAURANTS
        if ($request->item_id) {
          $restaurant  =  Restaurant::find($request->item_id);
          $return  =  $restaurant->update($restaurants);
          // CREATE RESTAURANTS
        } else {
          $restaurant = Restaurant::create($restaurants);
        }
        // REMOVE THE CATEGORY
        $cat_ids = explode(',', $request->categories);
        $restaurant_categories  = RestaurantCategory::where('restaurant_id', $request->item_id)->get();

        foreach ($restaurant_categories as $category) {
          $category->delete();
        }
        // SAVE CATEGORY
        foreach ($cat_ids as $cat_id) {
          $cat_data = [
            'owner_id' => $restaurant->owner->id,
            'restaurant_id' => $restaurant->id,
            'category_id' => $cat_id
          ];
          RestaurantCategory::create($cat_data);
        }
        if ($restaurant || $return) {
          DB::commit();
          return $this->sendResponse(trans('common.updated_success'),[]);
        } else {
          DB::rollback();
        }
      }
      // $this->ajaxError([], trans('common.try_again'));
    } catch (Exception $e) {
      $this->ajaxError($e->getMessage(),[]);
    }
  }



  public function ajax($id = null)
  {
    try {
      // GET LIST
      $query = User::whereIn('user_type', ['Customer'])->orderBy('id', 'DESC')->get();
      if ($query) {
        foreach ($query as $key => $list) {
			$query[$key]->action = '<div class="widget-content-right widget-content-actions">
                      <a class="border-0 btn-transition btn btn-outline-success" href="' . route("users.edit", $list->id) . '"><i class="fa fa-eye"></i></a>
                      </div>';

			$user_status_array = ['active'=>'', 'inactive'=>'', 'pending'=>'', 'blocked'=>''];
			if($list->status == 'active') { $user_status_array['active'] = 'selected'; }
			if($list->status == 'inactive') { $user_status_array['inactive'] = 'selected'; }
			if($list->status == 'pending') { $user_status_array['pending'] = 'selected'; }
			if($list->status == 'blocked') { $user_status_array['blocked'] = 'selected'; }
			$user_status = "<select class='form-control change_user_status' id='$list->id'>
								<option value='active' 	". $user_status_array['active'] .">Active</option>
								<option value='inactive'". $user_status_array['inactive'] .">Inactive</option>
								<option value='pending' ". $user_status_array['pending'] .">Pending</option>
								<option value='blocked' ". $user_status_array['blocked'] .">Blocked</option>
							</select>";

			$query[$key]->user_status = $user_status;

			$profile_status_array = ['0'=>'', '1'=>'', '2'=>''];
			if($list->is_approved == '0') { $profile_status_array[0] = 'selected'; }
			if($list->is_approved == '1') { $profile_status_array[1] = 'selected'; }
			if($list->is_approved == '2') { $profile_status_array[2] = 'selected'; }
			$profile_status = "<select class='form-control change_approve_status' id='$list->id'>
								<option value='0' ". $profile_status_array[0] .">Pending</option>
								<option value='1' ". $profile_status_array[1] .">Approved</option>
								<option value='2' ". $profile_status_array[2] .">Rejected</option>
							</select>";
			$query[$key]->profile_status = $profile_status;
        }
        return $this->sendResponse(trans('common.data_found_success'),$query);
      }
      return $this->sendResponse(trans('common.data_found_empty'),[]);
    } catch (Exception $e) {
      $this->ajaxError($e->getMessage(),[]);
    }
  }
	public function change_status(Request $request)
	{
		DB::beginTransaction();
		try {
			$res = User::where('id', $request->id)->update(['status' => $request->status]);

			if ($res) {
				DB::commit();
				return $this->sendResponse(trans('common.updated_success'),['status' => 'success']);
			} else {
				DB::rollback();
				return $this->sendResponse(trans('common.updated_error'),['status' => 'error']);
			}
		} catch (Exception $e) {
			DB::rollback();
			$this->ajaxError($e->getMessage(),[]);
		}
	}

	public function change_approve_status(Request $request)
	{
		DB::beginTransaction();
		try {
			$res = User::where('id', $request->id)->update(['is_approved' => $request->status]);

			if ($res) {
				DB::commit();
				return $this->sendResponse(trans('common.updated_success'),['status' => 'success']);
			} else {
				DB::rollback();
				return $this->sendResponse(trans('common.updated_error'),['status' => 'error']);
			}
		} catch (Exception $e) {
			DB::rollback();
			$this->ajaxError($e->getMessage(),[]);
		}
	}
}
