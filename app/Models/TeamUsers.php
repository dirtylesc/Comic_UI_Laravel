<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamUsers extends Model
{
    use HasFactory;

    protected $table = 'team_users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'team_id',
        'user_id',
        'created_at',
        'updated_at',
    ];
}
