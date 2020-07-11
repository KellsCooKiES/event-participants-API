<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = ['name','surname','email'];

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }
}
