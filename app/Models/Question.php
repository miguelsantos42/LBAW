<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    public $timestamps = false;

    /**
     * Get the comments for the question.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'questionid'); // Ensure 'questionId' matches the foreign key in your comments table
    }
}
