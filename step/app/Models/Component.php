<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;
    protected $fillable = [
        'content',
    ];
    public function group(){
        return $this->belongsToMany(Group::class, 'component_group');
    }

    protected $hidden = ['pivot', 'updated_at', 'created_at'];
}
