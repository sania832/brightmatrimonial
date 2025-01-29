<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable,HasRoles,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name','name', 'email', 'password','phone_number','user_type','status','civil_id_number','registered_by','is_subscribed','added_by','added_by_id','profile_image','country_code','dob','gender','age','noti_via_nitification','noti_via_email','time_format','vendor_approved','live_at','email_verified_at','profile_for','profile_photo_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function device_detail()
    {
        return $this->hasOne('App\Models\DeviceDetail','user_id');
    }

    public function bio()
    {
        return $this->hasOne(UserBio::class,'user_id');
    }

    public function address()
    {
        return $this->hasOne('App\Models\Address','owner_id')->where('owner_type','Customer');
    }
}
