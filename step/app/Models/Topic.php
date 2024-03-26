<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    protected $fillable = [
        'topic_name',
        'description',
        'category_id',
        'creator_id',
        'creator_id',
        'like_count',
        'dislike_count',
    ];
    public function Group()
    {
        return $this->belongsToMany(Group::class, 'group_topic');
    }

}
