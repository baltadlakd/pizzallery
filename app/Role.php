<?php

namespace pizzallery;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  public function users()
  {
    return $this
    ->belongsToMany('pizzallery\User')
    ->withTimestamps();
  }
}
