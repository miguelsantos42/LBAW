<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoteComment extends Model
{
    protected $table = 'votecomments';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
        'updown', 'usersid', 'commentid',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'usersid');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'commentid');
    }
}
