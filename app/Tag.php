<?php

namespace pizzallery;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
  protected $fillable = ['ingrediente'];
  public $timestamps = false;

  public function pizzas()
  {
      return $this->morphedByMany('pizzallery\Pizza', 'taggable');
  }
  public function hamburgers()
  {
      return $this->morphedByMany('pizzallery\Hamburger', 'taggable');
  }
}
