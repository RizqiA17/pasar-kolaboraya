<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaboration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'created_by',
        'title',
        'description',
        'status',
    ];

    public function getCollaboration()
    {
        return $this->hasMany(CollaborationUser::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function members()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function todos()
    {
        return $this->hasMany(Todo::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}


