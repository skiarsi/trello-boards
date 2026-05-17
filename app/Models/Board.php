<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Board extends Model
{
    public function getRouteKeyName(){
        return 'slug';
    }

    protected $fillable = ['title','slug','is_archive','description','color','owner_id'];


    // relations
    public function users()
    {
        return $this->belongsToMany(User::class, 'board_user')
            ->withPivot('status','role')
            ->withTimestamps();
    }

    // Members
    public function members()
    {
        return $this->users()->wherePivot('status', 'accepted');
    }

    // Waiting List
    public function pendingUsers()
    {
        return $this->users()->wherePivot('status', 'pending');
    }

    // owners
    public function owner(){
        return $this->belongsTo(User::class);
    }

    // all members
    public function activeUsers()
    {
        return $this->users()->wherePivotIn('status', ['accepted', 'owner']);
    }

    public function lists()
    {
        return $this->hasMany(Boardlist::class);
    }

    public function labels(){
        return $this->morphMany(Label::class,'labelable');
    }




    // helper
    public function currentUserRole(){
        return $this->users()
                    ->where('user_id', Auth::id())
                    ->first()
                    ?->pivot->role;
    }
}
