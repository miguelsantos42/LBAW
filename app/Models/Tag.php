<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Collection;

class Tag extends Model
{
    public $timestamps = false;

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'questiontags', 'tagid', 'questionid');
    }

    public function followers()
    {
        return $this->belongsToMany(Tag::class, 'followedTags', 'tagid', 'usersid');
    }
}