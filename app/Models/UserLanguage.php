<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLanguage extends Model
{
    use HasFactory;
    protected $table = 'user_languages';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'language_id',
    ];

    public $timestamps = false;
}
