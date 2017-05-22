<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//eloquent model voor users

class User extends Model
{
    //properties
    protected $fillable = array('username', 'hash', 'first_name', 'last_name', 'role', 'address');

    public $timestamps = false;

    //Many to many relation met events
    public function events() {
        return $this->belongsToMany('App\Event', 'users_events', 'user_id', 'event_id');
    }
}
