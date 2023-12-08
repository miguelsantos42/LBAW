<?php

// app/Models/Comment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; 

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'usersId', 'questionId', 'voteCount', 'edited', 'isDeleted', 'parent_id'];
    protected $dates = ['date']; 

    public $timestamps = false;

    public function question()
    {
        return $this->belongsTo(Question::class, 'questionid');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'usersid'); 
    }
    public function votes() {
        return $this->hasMany(Vote::class, 'commentid');
    }
}

