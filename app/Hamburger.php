<?php

namespace pizzallery;

use Illuminate\Database\Eloquent\Model;

class Hamburger extends Model
{
  public function user()
  {
    return $this->belongsTo('pizzallery\User');
  }
  public function comments()
  {
    return $this->morphMany('pizzallery\Comment', 'commentable');
  }
  public function ingredientes()
  {
    return $this->morphToMany('pizzallery\Tag', 'taggable');
  }
}
