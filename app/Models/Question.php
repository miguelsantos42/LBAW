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
        // Ensure the foreign key is specified exactly as it is in the database
        return $this->hasMany(Comment::class, 'questionid'); // Use 'questionid' instead of 'questionId'
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'usersid');
    }
}
