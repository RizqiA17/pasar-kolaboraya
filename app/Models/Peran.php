<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peran extends Model
{
    protected $table = 'peran';
    
    protected $fillable = [
        'nama',
        'deskripsi'
    ];

    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }
}
