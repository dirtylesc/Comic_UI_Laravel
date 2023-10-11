<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';
    protected $primaryKey = 'id';
    protected $fillable = [
        'messages',
        'type',
        'status',
        'user_id',
        'comic_id',
        'rating_id',
        'chapter_id',
        'comment_id',
        'created_at',
        'deleted_at',
    ];
}
