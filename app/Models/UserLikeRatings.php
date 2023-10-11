<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLikeRatings extends Model
{
    use HasFactory;

    protected $table = 'user_like_ratings';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'rating_id',
    ];

    public $timestamps = false;
}
