<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'options';

    protected $fillable = ['title','slug','type','status','parent'];

    public static function get($name){
    	$value = Setting::where('name',$name)->first();
    	return $value->value;
    }
    public static function has($name){
    	$value = Setting::where('name',$name)->first();
    	if($value){
    		return true;
    	} else {
    		return false;
    	}
    }
}
