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

    //Geef alle events terug
    public function getAll()
    {
        return Event::all();
    }

    //Geef alle events terug mbhv een event id
    public function getById($id)
    {
        return Event::where('id', $id)->get();
    }

    //Geef alle events terug van een gebruiker
    function getByName($name)
    {
        return User::where('username',$name)->first()->events()->get();
    }

    // create new event
    // Bij het maken van een event krijgen we een lijst van alle
    // gebruikers dat de maker van een event heeft gekozen
    // op deze manier creeren we een relatie van events met users
    function store($array, $users)
    {
        $event = Event::create($array);
        $userAr = explode('$', $users); //split de array die we krijgen in een array van gebruikers

        for ($i = 0; $i < count($userAr)-1; $i++)
        {
            //hier vragen we elk gebruiker op dat in de array van
            //gebruikers zit en maken de relatie met het event dat wordt gemaakt
            $user = User::where('username', $userAr[$i])->first();
            $event->users()->attach($user);
        }
        return $event;
    }

    //edit een event adhv een id en het originele object
    function edit($id, $newData)
    {
        Event::where('id', $id)->update($newData);
    }

    //delete een event adhv id
    function delete($id)
    {
        Event::where('id',$id)->delete();
    }

    //Leeg implementatie van IRepository interface
    public function index($searchKey)
    {
        // TODO: Implement index() method.
    }
}