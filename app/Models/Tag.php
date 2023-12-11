
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['tagName']; //por agora fica assim; mas sq adicionar descrição
    
    public function questions()
        {
            return $this->belongsToMany(Question::class);
        }
}