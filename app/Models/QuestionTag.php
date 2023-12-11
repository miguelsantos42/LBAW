<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestionTag
 *
 * @property int $id_tag
 * @property int $id_question
 *
 * @property Tag $tag
 * @property Question $question
 *
 * @package App\Models
 */
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
