<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $fillable = ['title','color','description'];

    public function borderlist(){
        return $this->belongsToMany(BoardList::class)
                        ->withPivot('title')
                        ->withTimestamps();
    }
}
