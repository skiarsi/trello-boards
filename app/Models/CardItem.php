<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardItem extends Model
{

    protected $fillable = ['card_id','title','is_completed','completed_by_id','completed_at'];

    public function completedBy()
    {
        return $this->belongsTo(User::class, 'completed_by_id');
    }

    protected $casts = [
        'completed_at' => 'datetime',
    ];
}
