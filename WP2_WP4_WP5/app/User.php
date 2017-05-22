<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    protected $fillable = array('username', 'hash', 'first_name', 'last_name', 'role', 'address');

    public $timestamps = false;

    public function events() {
        return $this->belongsToMany('App\Event', 'users_events', 'user_id', 'event_id');
    }
}
