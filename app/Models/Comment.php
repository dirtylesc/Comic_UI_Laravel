<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'messages',
        'like',
        'pin',
        'image',
        'user_id',
        'rating_id',
        'created_at',
        'updated_at',
    ];

    public function getUpdatedAtAgoAttribute()
    {
        return strtotime($this->updated_at);
    }
}
