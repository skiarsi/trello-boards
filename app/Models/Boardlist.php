<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boardlist extends Model
{

    protected $fillable = ['board_id','title','slug','position','collapsed','color','archived'];



    public function getRouteKeyName(){
        return 'slug';
    }

    public function board(){
        return $this->belongsTo(Board::class);
    }

    public function cards(){
        return $this->hasMany(Card::class, 'boardlists_id');
    }

    public function labels(){
        return $this->belongsToMany(Label::class)
                        ->withPivot('title')
                        ->withTimestamps();
    }




    // scopes

    // archived scope
    public function scopeArchived($query){
        return $query->where('archived', true );
    }

    public function scopeNotArchived($query){
        return $query->where('archived', false);
    }
}
