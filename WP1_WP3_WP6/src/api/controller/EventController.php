<?php namespace controller;

use model\Event;
use model\IEventRepository;

class EventController
{

    private $EventRepository;

    function __construct(IEventRepository $eventRepository)
    {
        $this->EventRepository =  $eventRepository;
    }

    //Requesting all events
    public function getAllEvents()
    {
        $events = $this->EventRepository->getAllEvents();
        echo json_encode($events);
    }

    //Requesting events by event_id only
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

    //Requesting events by a person (who originally created the event)
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

    //Requesting events between a certain date
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

    //Requesting events by person id AND between a certain date
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

    //Decode incoming request from json to array to eventually store it in the db
    public function postEvent($newEvent)
    {
       $event = new Event();
       $arr = json_decode($newEvent,true);

       //assigning all the incoming properties to the object
       $event->title = $arr['title'];
       $event->description = $arr['description'];
       $event->location = $arr['location'];
       $event->start_date = $arr['start_date'];
       $event->end_date = $arr['end_date'];
       $event->organiser = $arr['organiser'];
       $event->invited = $arr['invited'];
       $event->event_ownerId = $arr['event_ownerId'];

      $rowsChanged =  $this->EventRepository->storeEvent($event);
      if($rowsChanged == 1){
          echo $rowsChanged;
      }
      else{
          echo "Error while posting the event";
      }

    }
    //Edit an event by decoding the incoming request and replacing the original object with the updated one
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
        $rowsChanged = $this->EventRepository->editEvent($id, $updatedEvent);

        if($rowsChanged == 1){
            echo $rowsChanged;
        }
        else{
            echo "Error while updating the event";
        }
    }

    // Delete event by a given ID
    public function deleteEvent($id)
    {
        $rowsChanged = $this->EventRepository->deleteEvent($id);
        if($rowsChanged == 1){
            echo $rowsChanged;
        }
        else {
            echo "Error while deleting the event";
        }
    }
}