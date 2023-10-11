<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComicCategories extends Model
{
    use HasFactory;

    protected $table = 'comic_categories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'comic_id',
        'category_id',
    ];
    public $timestamps = false;
}
