<?php

namespace pizzallery;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Tarjeta extends Model
{
  use Notifiable;
    protected $fillable = ['name','address','number', 'month', 'year','ccv'];

    public function user(){
      return $this->belongsTo('pizzallery\User');
    }

    //accessors
    public function getDateAttribute(){
        return $this->month . '/' . $this->year;
    }

    public function setNumberAttribute($value)
    {
      $this->attributes['number'] = substr($value,0,4). ' '. substr($value,4,4). ' '. substr($value,8,4). ' '. substr($value,12,strlen($value)-12);
    }
}
