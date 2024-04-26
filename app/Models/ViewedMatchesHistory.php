<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewedMatchesHistory extends Model
{
    protected $table = 'viewed_matches_history';

    protected $fillable = ['user_id','viewed_id','last_view_date','last_view_time'];
}
