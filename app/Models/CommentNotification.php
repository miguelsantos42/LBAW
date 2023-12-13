<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentNotification extends Model
{
    protected $table = 'commentnotification';
    public $timestamps = false;

    protected $fillable = [
        'notificationid', 'commentid',
    ];

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notificationid');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'commentid');
    }
}
