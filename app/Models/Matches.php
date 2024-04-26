<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
    protected $table = 'matches';
    
    protected $fillable = ['user_id', 'match_id','question_match','is_read'];

    public function bio()
    {
        return $this->hasOne(UserBio::class,'user_id','id');
    }
    // Get User detail
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    // Get Friend detail
    public function friend(){
        return $this->belongsTo(User::class,'match_id');
    } 
}