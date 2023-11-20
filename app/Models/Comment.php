<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Specify the correct table name
    protected $table = 'comment';

    // Define the relationship back to the question
    // Comment model
    public function question()
    {
        // The second parameter is the foreign key column name in the 'comment' table.
        return $this->belongsTo(Question::class, 'question_id'); // change 'questionId' to 'question_id'
    }

}
