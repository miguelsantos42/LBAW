<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionTag extends Model
{
	protected $table = 'question_tag';
	
    //public $incrementing = false;

	protected $casts = [
		'tagId' => 'int',
		'questionId' => 'int'
	];

	protected $fillable = [
		'tagId',
		'questionId'
	];

	public function tag()
	{
		return $this->belongsTo(Tag::class, 'tagId');
	}

	public function question()
	{
		return $this->belongsTo(Question::class, 'questionId');
	}
}
