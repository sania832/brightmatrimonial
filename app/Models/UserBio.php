<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBio extends Model
{
    protected $table = 'users_bio';

    protected $fillable = [
  		'step','first_name','email','phone_number','last_name','user_id','religion','community','mother_tongue',
		'state','city','live_with_family','marital_status','diet','height','horoscope_require','manglik',
		'highest_qualificatin','company_name','income_type','income','position',
		'relation_type','cast','sub_cast','family_type','family_status','father_occupation','brother','sister','family_living_in','family_bio','family_address','family_contact_no',
		'about','country_code','mobile_no',
		'document_type','document_number','document',
		'sexual_orientation','hobbies','interest','ug_digree','pg_digree','highest_qualification','occupation','company_position','working_professional','favorite_music','favorite_books','dress_style','favorite_movies','favorite_sports','cuisine','sun_sign','rashi','nakshtra',
		'dob','tob','age','profile_image','cover_image','open_to_pets'
    ];

    public function user(){
        //return $this->belongsTo('App\Models\User','id');
		return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
