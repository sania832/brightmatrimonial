<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $table = 'friends';
    
    protected $fillable = ['user_id', 'friend_id','last_seen'];

    public function bio()
    {
        return $this->hasOne(UserBio::class,'user_id', 'id');
    }
    // Get User detail
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    // Get Friend detail
    public function friend(){
        return $this->belongsTo(User::class,'friend_id');
    } 
}