<?php

namespace App\Models;

use App\Enums\ChapterStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Chapter extends Model
{
    use HasFactory;

    protected $table = 'chapters';
    protected $primaryKey = 'id';
    protected $fillable = [
        'comic_id',
        'user_id',
        'title',
        'number',
        'view',
        'status',
        'slug',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function images()
    {
        return $this->hasMany(ChapterImages::class);
    }

    public function getStatusNameAttribute()
    {
        return Str::title(ChapterStatusEnum::getKey($this->status));
    }
}
