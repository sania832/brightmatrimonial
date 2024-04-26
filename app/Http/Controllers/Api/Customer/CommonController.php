<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB,Settings;
use App\Models\Helpers\CommonHelper;
use App\Models\SmsVerificationNew;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;

class CommonController extends BaseController
{
    
    /**
     * General Information
     *
     * @return \Illuminate\Http\Response
     */
    public function general_information(Request $request)
	{
        try {
			$data = [
				'title' 			=> 'Bright Matrimony',
				'app_version'		=> '1.0.0',
				'copy_rights_year'	=> '2021',
				'xd_web'			=> 'https://xd.adobe.com/view/92d79f2a-c801-4fb6-8645-41eb808b1be0-c784/',
				'xd_mobile'			=> 'https://xd.adobe.com/view/be1e093d-ef34-41df-aeea-fb1147510cd9-eb4d/',
			];
			return $this->sendResponse($data, trans('customer_api.data_found_success'));
			
		} catch (Exception $e) {
			$this->ajaxError([], $e->getMessage());
		}
    }
	
	/**
     * CMS Pages
     *
     * @return \Illuminate\Http\Response
     */
    public function cms_pages(Request $request)
	{
        try {
			$data = [
				'about' 				=> 'https://matrimonial.trioency.com/about-us',
				'contact'				=> 'https://matrimonial.trioency.com/contact-us',
				'terms-and-conditions'	=> 'https://matrimonial.trioency.com/terms',
			];
			return $this->sendResponse($data, trans('customer_api.data_found_success'));
			
		} catch (Exception $e) {
			$this->ajaxError([], $e->getMessage());
		}
    }
}
