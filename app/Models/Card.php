<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['list_id','slug','title','description','position','color'];

    public function boardlist(){
        return $this->belongsTo(Boardlist::class);
    }

}
