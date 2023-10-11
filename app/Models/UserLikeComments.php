<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLikeComments extends Model
{
    use HasFactory;

    protected $table = 'user_like_comments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'comment_id',
    ];

    public $timestamps = false;
}
