<?php
/**
 * Created by PhpStorm.
 * User: Kenan
 * Date: 17/04/2017
 * Time: 23:55
 */
namespace App\Http\Repositories;
use App\User;
use App\Event;

//Repository for querying with eloquent
class UserRepository implements IRepository
{
    public function getAll()
    {
        return User::all();
    }

    public function getById($id)
    {
        return User::where('user_id', $id)->first();
    }

    public function assignUserToEvent($username,$event_id)
    {
       $user = User::where('username', $username)->get();
       $event = Event::where('event_id', $event_id)->get();
       $user->events()->attach($event);
    }

    public function getByName($name)
    {
        return User::where('username', $name)->first();
    }

    public function store($array)
    {
        return User::create($array);
    }

    public function edit($id, $newData)
    {
        if ($this->getById($id) !== null)
        {
            return User::where('user_id', $id)->update($newData);
        }
        else
        {
            return null;
        }
    }

    public function delete($user_id)
    {
        if ($this->getById($user_id) !== null)
        {
            User::where('user_id',$user_id)->delete();
        }
        else
        {
            return null;
        }
    }

    public function index($searchKey)
    {
        return User::where('first_name', 'like', $searchKey.'%')->get();
    }
}