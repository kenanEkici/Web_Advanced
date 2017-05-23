<?php namespace model;
/**
 * Created by PhpStorm.
 * User: Pieter-Jan
 * Date: 22/05/2017
 * Time: 21:58
 */



interface IEventRepository
{
    function __construct($pdo);

    function getAllEvents();

    function getEventByID($eventID);

    function getEventByOwnerId($personID);

    function getEventByDate($from, $until);

    function getEventByPersonAndDate($personID, $from, $until);

    function storeEvent($event);

    function editEvent($id, $updatedEvent);

    function deleteEvent($id);
}