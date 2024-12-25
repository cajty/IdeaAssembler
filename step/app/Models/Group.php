<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
    public function Component(){
        return $this->belongsToMany(Component::class, 'component_group');
    }
    public function Topic()
    {
        return $this->hasMany(Topic::class, 'group_topic');
    }
    protected $hidden = ['pivot', 'updated_at', 'created_at'];
}
