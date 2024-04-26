<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interested extends Model
{
    protected $table = 'interested';

    protected $fillable = ['user_id','person_id','status'];
}
