<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Card extends Model
{
    protected $fillable = ['list_id','slug','title','description','position','color'];

    public function boardlist(){
        return $this->belongsTo(Boardlist::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class,'commentable');
    }

    public function labels(): MorphMany
    {
        return $this->morphMany(Label::class, 'labelable');
    }

}
