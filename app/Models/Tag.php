<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Collection;

class Tag extends Model
{
     protected $table = 'tags';

     protected $primaryKey = 'id';
 
     public $timestamps = false;
 
     protected $fillable = ['tagname'];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'questiontags', 'tagid', 'questionid');
    }

    public function followers()
    {
        return $this->belongsToMany(Tag::class, 'followedtags', 'tagid', 'usersid');
    }


}