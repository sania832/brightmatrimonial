<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    // Define the table if it's not following Laravel's convention
    protected $table = 'user_profiles';

    // Define the fillable columns to prevent mass assignment issues
    protected $fillable = ['user_id', 'profile_photo_path'];
}
