<?php

namespace pizzallery;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    protected $fillable = ['original', 'hashed', 'mime','size','path'];
}
