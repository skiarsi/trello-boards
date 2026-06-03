<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    protected $fillable = ['checklist_id','title','is_completed','completed_by_id','completed_at'];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    public function completedBy()
    {
        return $this->belongsTo(User::class, 'completed_by_id');
    }



    protected $casts = [
        'completed_at' => 'date',
    ];
}
