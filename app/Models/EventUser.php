<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventUser extends Model
{
    protected $table = 'event_users';
    protected $fillable = ['event_id', 'user_id', 'role'];

    public function event(){
        return $this->belongsTo(Event::class);
    }
}
