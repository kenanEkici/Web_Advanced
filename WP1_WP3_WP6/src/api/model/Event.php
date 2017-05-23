<?php namespace model;

//Model for our event object
class Event
{
    public $id;
    public $event_ownerId;
    public $title;
    public $organiser;
    public $start_date;
    public $end_date;
    public $location;
    public $description;
    public $invited;
}