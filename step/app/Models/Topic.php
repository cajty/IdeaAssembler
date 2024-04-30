<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    protected $hidden = ['pivot', 'updated_at', 'created_at'];
    protected $fillable = [
        'topic_name',
        'description',
        'category_id',
        'creator_id',
        'like_count',
        'is_public',
        'dislike_count',
    ];
    public function Group()
    {
        return $this->belongsToMany(Group::class, 'group_topic');
    }

    public function Category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function Feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    public function Tag()
    {
        return $this->belongsToMany(Tag::class, 'tag_topic');
    }
    

}
