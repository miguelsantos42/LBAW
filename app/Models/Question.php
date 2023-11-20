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
        // The second parameter is the foreign key column name in the 'comment' table.
        return $this->hasMany(Comment::class, 'question_id'); // Ensure this matches the column name in the database.
    }
}
