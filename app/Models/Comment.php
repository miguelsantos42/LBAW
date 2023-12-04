<?php

// app/Models/Comment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Specify the primary key and foreign key names explicitly if they do not follow Laravel's naming conventions
    protected $primaryKey = 'id'; // This is probably already correct
    protected $foreignKey = 'questionid'; // This should match your database column name exactly

    protected $fillable = ['content', 'usersId', 'questionid', 'voteCount', 'edited', 'isDeleted']; // Make sure 'questionid' is lowercase here if it is lowercase in your database

    public $timestamps = false;

    // Relationship back to the question
    public function question()
    {
        // Ensure the foreign key is specified exactly as it is in the database
        return $this->belongsTo(Question::class, 'questionid'); // Use 'questionid' instead of 'questionId'
    }
}
