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
        return User::where('id', $id)->first();
    }

    public function getByName($name)
    {
        return User::where('username', $name)->first();
    }

    public function store($array,$users)
    {
        return User::create($array);
    }

    public function edit($id, $newData)
    {
        if ($this->getById($id) !== null)
        {
            return User::where('id', $id)->update($newData);
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
            User::where('id',$user_id)->delete();
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