<?php
/**
 * Created by PhpStorm.
 * User: Kenan
 * Date: 17/04/2017
 * Time: 23:55
 */

namespace App\Http\Repositories;
use App\Event;
use App\User;

//repository for querying data with eloquent
class EventRepository implements IRepository
{
    public function getAll()
    {
        return Event::all();
    }

    public function getById($id)
    {
        return Event::where('id', $id)->get();
    }

    function getByName($name)
    {
        return User::where('username',$name)->first()->events()->get();
    }

    //  create new event   <--- event (has an array of users)
    function store($array, $users)
    {
        $event = Event::create($array);
        $userAr = explode('$', $users);

        for ($i = 0; $i < count($userAr)-1; $i++)
        {
            $user = User::where('username', $userAr[$i])->first();
            $event->users()->attach($user);
        }

        return $event;
    }

    function edit($id, $newData)
    {
        Event::where('id', $id)->update($newData);
    }

    function delete($id)
    {
        Event::where('id',$id)->delete();
    }

    public function index($searchKey)
    {
        // TODO: Implement index() method.
    }
}