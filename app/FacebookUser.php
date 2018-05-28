<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class FacebookUser extends Authenticatable
{


  protected $fillable = ['facebook_id', 'name', 'email', 'avatar'];


}
