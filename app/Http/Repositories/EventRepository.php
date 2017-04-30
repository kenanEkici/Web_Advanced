<?php
/**
 * Created by PhpStorm.
 * User: Kenan
 * Date: 17/04/2017
 * Time: 23:55
 */

namespace App\Http\Repositories;
use App\Event;

//repository for querying data with eloquent
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

    function getByName($title)
    {
        return Event::where('invited', 'like','%'.$title.'%')->get();
    }

    function store($array)
    {
        return Event::create($array);
    }

    function edit($id, $newData)
    {
        Event::where('event_id', $id)->update($newData);
    }

    function delete($id)
    {
        Event::where('event_id',$id)->delete();
    }

    public function searchByIndex($searchKey)
    {
        // TODO: Implement searchByIndex() method.
    }

    public function index($searchKey)
    {
        // TODO: Implement index() method.
    }
}