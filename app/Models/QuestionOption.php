<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    protected $table = 'question_options';

    protected $fillable = ['for','question_id','type','Male','Female'];
	
	public function questation()
    {
		return $this->belongsTo(Question::class, 'question_id' );
    }
}