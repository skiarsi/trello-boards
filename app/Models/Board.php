<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    public function getRouteKeyName(){
        return 'slug';
    }

    protected $fillable = ['title','slug','is_archive','description','color','owner_id'];


    // relations
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role')
            ->withTimestamps();
    }


    public function owner(){
        return $this->belongsTo(User::class);
    }

    public function lists()
    {
        return $this->hasMany(BoardList::class);
    }
}
