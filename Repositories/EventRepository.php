<?php
/**
 * Created by PhpStorm.
 * User: Kenan
 * Date: 29/03/2017
 * Time: 23:01
 */

//CRUD FUNCTIONS
require_once('ConnectToRemote');
require_once('Event');

class EventRepository
{

    public function getAllEvents() //returns data, wraps them in a model and returns a list of event objects
    {
        $events = array();
        $statement = connect()->prepare('SELECT * FROM event_table');
        $statement->execute();
        $result_array = $statement->fetchAll();

        foreach($result_array as $event)
        {
           array_push($events, new Event($event[0], $event[1], $event[2], $event[3]));
        }
        return $events;
    }

    public function getEventById($id) //return a single event object
    {
        foreach($this->getAllEvents() as $event)
        {
            if ($event->getId() == $id)
            {
                return $event;
            }
        }
    }

    public function getEventByStartDateAndEndDate($start, $end)
    {

    }

    public function addEvent($user, $start, $end, $location)
    {

    }

    public function deleteEventByGivenId($id)
    {

    }

    public function deleteAllEventsOfGivenUser($user)
    {

    }

    public function deleteEventsOfGivenUserByGivenStartAndEndDate($user,$start,$end)
    {

    }


}