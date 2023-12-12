<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoteNotification extends Model
{
    protected $table = 'voteNotification';
    public $timestamps = false;

    protected $fillable = [
        'date', 'status', 'updown', 'usersId', 'commentId', 'questionId', 'voterId',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'usersId');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'commentId');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'questionId');
    }

    public function voter()
    {
        return $this->belongsTo(User::class, 'voterId');
    }
}