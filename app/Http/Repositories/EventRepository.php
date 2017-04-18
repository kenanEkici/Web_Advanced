<?php
/**
 * Created by PhpStorm.
 * User: Kenan
 * Date: 17/04/2017
 * Time: 23:55
 */

namespace App\Http\Repositories;
use App\Event;


class EventRepository
{
    public function getAll()
    {
        return Event::all();
    }

    public function getById($id)
    {
        return Event::where('event_id', $id)->get();
    }

    public function create(Array $array)
    {
        return Event::create($array);
    }

    public function update(Request $request, $id)
    {
        echo 'update';
    }

    public function destroy($id)
    {
        Event::where('event_id',$id)->destroy();
    }
}