<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function topics()
{
    return $this->belongsToMany(Topic::class, 'tag_topic');
}
    protected $hidden = [ 'updated_at', 'created_at'];

}
