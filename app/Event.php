<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
  protected $fillable = ['name','event_date' ,'place'];

  public function participants()
  {
        return $this->hasMany(Participant::class);
  }
}
