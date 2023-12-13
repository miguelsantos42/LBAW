<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notification';
    public $timestamps = false;

    protected $fillable = [
        'content', 'date', 'status', 'usersid', 'questionid',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'usersid');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'questionid');
    }
}
