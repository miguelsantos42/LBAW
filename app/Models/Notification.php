<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notification';
    public $timestamps = false;

    protected $fillable = [
        'content', 'date', 'status', 'usersid', 'questionid',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'usersid');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'questionid');
    }
    public function commentNotification()
    {
        return $this->hasOne(CommentNotification::class, 'notificationid');
    }
    public function voteNotifications()
    {
        return $this->hasMany(VoteNotification::class, 'id');
    }

}
