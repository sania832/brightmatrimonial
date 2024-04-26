<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';

    protected $fillable = ['slug', 'Male', 'Female', 'status'];

    public function options()
    {
        return $this->hasMany(QuestionOptions::class, 'question_id','id');
    }
}
