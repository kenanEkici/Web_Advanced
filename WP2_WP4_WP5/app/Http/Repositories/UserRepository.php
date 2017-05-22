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
    //geef alle users terug
    public function getAll()
    {
        return User::all();
    }

    //geef een user terug adhv een id
    public function getById($id)
    {
        return User::where('id', $id)->first();
    }

    //geef een user adhv een naam
    public function getByName($name)
    {
        return User::where('username', $name)->first();
    }

    //Sla een gebruik op, $users is een lege implementatie vanwege de IRepository
    public function store($array,$users)
    {
        return User::create($array);
    }

    //Wijzig een gebruiker adhv een id en het nieuwe object
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

    //Verwijder een gebruiker adhv id
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

    //Zoek een gebruiker adhv een zoekopdracht, wordt vergeleken met firstname
    public function index($searchKey)
    {
        return User::where('first_name', 'like', $searchKey.'%')->get();
    }
}