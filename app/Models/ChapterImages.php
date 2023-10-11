<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChapterImages extends Model
{
    use HasFactory;

    protected $table = 'chapter_images';
    protected $primaryKey = 'id';
    protected $fillable = [
        'link',
        'chapter_id',
    ];

    public $timestamps = false;
}
