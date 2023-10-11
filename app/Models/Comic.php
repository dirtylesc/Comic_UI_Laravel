<?php

namespace App\Models;

use App\Enums\ComicLanguageEnum;
use App\Enums\ComicStatusEnum;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Comic extends Model
{
    use HasFactory;
    use Sluggable;

    protected $table = 'comics';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'name',
        'alias',
        'avatar',
        'author',
        'language',
        'description',
        'status',
        'pre_view',
        'slug',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'comic_categories',
            'comic_id',
            'category_id'
        );
    }

    public function firstCategory()
    {
        return $this->hasOne(ComicCategories::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function chapter()
    {
        return $this->hasOne(Chapter::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['name', '(alias)']
            ]
        ];
    }

    public function getLanguageNameAttribute()
    {
        return Str::title(ComicLanguageEnum::getKey($this->language));
    }

    public function getStatusNameAttribute()
    {
        return ComicStatusEnum::getKeyByValue($this->status);
    }

    public function getCreatedAtTimeAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }
}
