<?php

// app/Models/Question.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    public $timestamps = false;

    // Relationship with comments
    public function comments()
    {
        return $this->hasMany(Comment::class, 'questionid'); 
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'usersid');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'questiontags', 'questionid', 'tagid');
    }
    public function follows()
    {
        return $this->belongsToMany(User::class, 'followedquestions', 'questionid', 'usersid');
    }
    

}
