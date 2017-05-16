<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $fillable = array('organiser','event_ownerId','title','description','start_date', 'end_date','location', 'invited');

    public $timestamps = false;

    public function users() {
        return $this->belongsToMany('App\User', 'users_events', 'event_id', 'user_id');
    }

    protected function getDateFormat()
    {
        return 'd.m.Y H:i:s';
    }

}
