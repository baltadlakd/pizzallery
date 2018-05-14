<?php

namespace pizzallery;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tarjeta;
use Illuminate\Database\Eloquent\SoftDeletes;
use Role;

class User extends Authenticatable
{
  use Notifiable;
  use SoftDeletes;

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = ['name', 'email', 'password',];

  protected $dates = ['deleted_at'];

  /**
  * The attributes that should be hidden for arrays.
  *
  * @var array
  */
  protected $hidden = [
    'password', 'remember_token',
  ];

  public function socialProvider(){
    return $this->hasMany('pizzallery\SocialProvider');
  }

  public function tarjetas(){
    return $this->hasMany('pizzallery\Tarjeta');
  }

  public function pizzas(){
    return $this->hasMany('pizzallery\Pizza');
  }
  public function comments(){
    return $this->hasMany('pizzallery\Comment');
  }

  public function roles()
  {
    return $this->belongsToMany('pizzallery\Role')
    ->withTimestamps();
  }

  public function authorizeRoles($roles)
  {
    if ($this->hasAnyRole($roles)) {
      return true;
    }
    abort(401, 'Esta acción no está autorizada.');
  }
  public function hasAnyRole($roles)
  {
    if (is_array($roles)) {
      foreach ($roles as $role) {
        if ($this->hasRole($role)) {
          return true;
        }
      }
    } else {
      if ($this->hasRole($roles)) {
        return true;
      }
    }
    return false;
  }
  public function hasRole($role)
  {
    if ($this->roles()->where('name', $role)->first()) {
      return true;
    }
    return false;
  }


}
