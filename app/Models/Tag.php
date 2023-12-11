<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Collection;

class Tag extends Model
{
 
    protected $table = 'tag';

    protected $primaryKey = 'id';

    protected $fillable = ['tagName']; //por agora fica assim; mas sq adicionar descrição
    
    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }

    /*
    public function questions()
	{
		return $this->belongsToMany(Question::class, 'questionTag', 'questionId', 'tagId');
	}*/

}