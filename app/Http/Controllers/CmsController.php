<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class CmsController extends Controller
{

    /**
     * Show the application CMS pages.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function aboutUs(){
		$page		= 'about-us';
        $page_title = trans('title.about_us');
		
		return view('theme/about-us',compact('page', 'page_title'));
    }
	
	public function takeAtour(){
		$page		= 'about-us';
        $page_title = trans('title.take_a_tour');
		
		return view('theme/about-us',compact('page', 'page_title'));
    }
	
	public function contactUs(){
		$page		= 'contact-us';
        $page_title = trans('title.contac_us');
		
		return view('theme/contact-us',compact('page', 'page_title'));
    }
	
	public function terms(){
		$page		= 'terms';
        $page_title = trans('title.terms');
		
		return view('theme/terms',compact('page', 'page_title'));
    }
	
	public function privacy(){
		$page		= 'privacy-policy';
        $page_title = trans('title.privacy_policy');
		
		return view('theme/privacy-policy',compact('page', 'page_title'));
    }
	
	public function page_notFound(){
		$page		= 'page_not_found';
        $page_title = trans('title.terms');
		
		return view('theme/404/index',compact('page', 'page_title'));
    }
	
}