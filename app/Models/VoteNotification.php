<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoteNotification extends Model
{
    protected $table = 'votenotification';
    public $timestamps = false;

    protected $fillable = [
        'date', 'status', 'updown', 'usersid', 'commentid', 'questionid', 'voterid',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'usersid');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'commentid');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'questionid');
    }

    public function voter()
    {
        return $this->belongsTo(User::class, 'voterid');
    }
}