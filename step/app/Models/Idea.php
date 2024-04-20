<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'content','user_id'];
    protected $hidden = ['updated_at', 'created_at', 'user_id'];

}
