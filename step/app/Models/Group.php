<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    public function Component(){
        return $this->belongsToMany(Component::class, 'component_id');
    }
    public function Topic()
    {
        return $this->belongsToMany(Topic::class, 'group_topic');
    }
}
