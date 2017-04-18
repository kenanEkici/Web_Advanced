<?php
/**
 * Created by PhpStorm.
 * User: Kenan
 * Date: 17/04/2017
 * Time: 23:55
 */

namespace App\Http\Repositories;
use App\Event;


class EventRepository implements IRepository
{
    public function getAll()
    {
        return Event::all();
    }

    public function getById($id)
    {
        return Event::where('event_id', $id)->get();
    }

    function getByName($name)
    {
        return Event::where('username', $name)->get();
    }

    function store($array)
    {
        return Event::create($array);
    }

    function edit($new, $old_id)
    {
        Event::where('event_id', $old_id)->update($new);
    }

    function delete($id)
    {
        Event::where('event_id',$id)->delete();
    }

    public function assignUserToEvent($event_id, $username)
    {
        // TODO: Implement assignUserToEvent() method.
    }
}