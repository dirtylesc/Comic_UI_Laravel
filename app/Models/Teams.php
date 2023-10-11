<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
    use HasFactory;

    protected $table = 'teams';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'avatar',
        'description',
        'status',
        'user_id',
        'created_at',
        'updated_at',
    ];

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'team_users',
            'team_id',
            'user_id'
        );
    }

    public function leader()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getCreatedAtTimeAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }
}
