<?php namespace controller;

use model\Event;
use model\EventRepository;

class EventController
{

    private $EventRepository;

    function __construct($pdo)
    {
        $this->EventRepository =  new EventRepository($pdo);
    }

    //Get Function
    public function getAllEvents()
    {
        $events = $this->EventRepository->getAllEvents();
        echo json_encode($events);


    }



    public function getAllUsers()
    {
        echo json_encode($this->EventRepository-> getAllUsers());
    }

    public function getEventById($eventId)
    {
        $event = $this->EventRepository->getEventByID($eventId);

        if ($event !== [])
        {
            echo json_encode($event);
        }
        else
        {
            echo "Event Not Found";
        }
    }

    public function getEventsByOwnerId($personId)
    {
        $event = $this->EventRepository->getEventByOwnerId($personId);

        if ($event !== [])
        {
            echo json_encode($event);
        }
        else
        {
            echo "User not found or user does not have any events";
        }
    }

    public function getEventsByDate($fromDate, $untilDate)
    {
        $event = $this->EventRepository->getEventByDate($fromDate, $untilDate);

        if ($event !== [])
        {
            echo json_encode($event);
        }
        else
        {
            echo "No event found, try another date interval";
        }
    }

    public function getEventsByPersonAndDate($personId, $fromDate, $untilDate)
    {
        $event = $this->EventRepository->getEventByPersonAndDate($personId,$fromDate,$untilDate);

        if ($event !== [])
        {
            echo json_encode($event);
        }
        else
        {
            echo "No event found, try other parameters";
        }
    }

    public function postEvent($newEvent)
    {
       $event = new Event();
       $arr = json_decode($newEvent,true);

       $event->title = $arr['title'];
       $event->description = $arr['description'];
       $event->location = $arr['location'];
       $event->start_date = $arr['start_date'];
       $event->end_date = $arr['end_date'];
       $event->organiser = $arr['organiser'];
       $event->invited = $arr['invited'];
       $event->event_ownerId = $arr['event_ownerId'];

      $this->EventRepository->storeEvent($event);
    }

    public function putEvent($id, $newEvent)
    {
        $updatedEvent = new Event();
        $arr = json_decode($newEvent,true);

        $updatedEvent->title = $arr['title'];
        $updatedEvent->description = $arr['description'];
        $updatedEvent->location = $arr['location'];
        $updatedEvent->start_date = $arr['start_date'];
        $updatedEvent->end_date = $arr['end_date'];
        $updatedEvent->organiser = $arr['organiser'];
        $updatedEvent->invited = $arr['invited'];
        $updatedEvent->event_ownerId = $arr['event_ownerId'];
        $this->EventRepository->editEvent($id, $updatedEvent);
    }

    public function deleteEvent($id)
    {
        $this->EventRepository->deleteEvent($id);
    }
}