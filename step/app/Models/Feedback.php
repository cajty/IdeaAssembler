<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $fillable = [
        'topic_id',
        'user_id',
        'is_like',
    ];
    protected $hidden = ['updated_at', 'created_at'];
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
