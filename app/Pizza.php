<?php

namespace pizzallery;

use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
  public function user()
  {
    return $this->belongsTo('pizzallery\User');
  }
  public function comments()
  {
    return $this->morphMany('pizzallery\Comment', 'commentable')->orderBy('id','DESC');
  }
  public function ingredientes()
  {
    return $this->morphToMany('pizzallery\Tag', 'taggable');
  }
}
