<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chat';
    public $timestamps = true;

    protected $fillable = ['user_id', 'friend_id','message','is_read'];

    // Get User detail
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function bio()
    {
        return $this->hasOne(UserBio::class,'friend_id','id');
    }

    // Get Friend detail
    public function friend(){
        return $this->belongsTo(User::class,'friend_id');
    }
}
