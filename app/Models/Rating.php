<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $table = 'ratings';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'comic_id',
        'rate',
        'messages',
        'like',
        'pin',
        'image',
        'created_at',
        'updated_at',
    ];

    public function getUpdatedAtAgoAttribute()
    {
        return strtotime($this->updated_at);
    }
}
