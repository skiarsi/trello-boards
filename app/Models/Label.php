<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $fillable = ['title','color','description'];

    public function labelable()
    {
        return $this->morphTo();
    }
}
