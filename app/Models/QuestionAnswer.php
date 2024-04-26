<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    protected $table = 'question_answers';

    protected $fillable = ['question_id','answer_id','user_id','type','gender'];

    public function options()
    {
        return $this->hasMany(QuestionOptions::class, 'question_id','id');
    }
	
	public function state()
    {
        return $this->belongsTo(Question::class, 'question_id' );
    }
}
