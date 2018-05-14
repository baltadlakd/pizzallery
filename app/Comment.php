<?php

namespace pizzallery;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

  protected $fillable = ['message','user_id'];

  public static function boot() {
    parent::boot();
    static::creating(function($comment) {
        $comment->user_id = auth()->id();
    });
}

  public function commentable()
  {
      return $this->morphTo();
  }
  public function user(){
    return $this->belongsTo('pizzallery\User');
  }
}
