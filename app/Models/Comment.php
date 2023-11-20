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
        return $this->belongsTo(Question::class, 'questionid');
    }

}