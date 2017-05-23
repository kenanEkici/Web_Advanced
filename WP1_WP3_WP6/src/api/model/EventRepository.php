<?php namespace model;

use PDO;
use PDOException;

class EventRepository implements IEventRepository
{
    private
        $pdo = null;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

//Database connections with queries
    function getAllEvents()
    {
        try {

            $statement = $this->pdo->prepare('SELECT * FROM events');
            $statement->execute();
            $result_array = $statement->fetchAll(PDO::FETCH_CLASS, __NAMESPACE__ . "\\Event");

            return $result_array;

        } catch (PDOException $e) {
            print 'Exception!: ' . $e->getMessage();
        }
    }

    function getAllUsers()
    {
        try {

            $statement = $this->pdo->prepare('SELECT * FROM users');
            $statement->execute();
            $result_array = $statement->fetchAll(PDO::FETCH_CLASS, __NAMESPACE__ . "\\User");

            return $result_array;

        } catch (PDOException $e) {
            print 'Exception!: ' . $e->getMessage();
        }
    }

    function getEventByID($eventID)
    {
        try {

            $statement = $this->pdo->prepare('SELECT * FROM events WHERE id = :eventid ');
            $statement->bindParam(':eventid', $eventID);
            $statement->execute();
            $result_array = $statement->fetchAll(PDO::FETCH_CLASS,__NAMESPACE__ . "\\Event");
            return $result_array;

        } catch
        (PDOException $e) {
            print 'Exception!: ' . $e->getMessage();
        }
    }

    function getEventByOwnerId($personID)
    {
        try {

            $statement = $this->pdo->prepare('SELECT * FROM events WHERE event_ownerId = :personid ');
            $statement->bindParam(':personid', $personID);
            $statement->execute();
            $result_array = $statement->fetchAll(PDO::FETCH_CLASS,__NAMESPACE__ . "\\Event");

            return $result_array;
        } catch
        (PDOException $e) {
            print 'Exception!: ' . $e->getMessage();
        }
    }

    function getEventByDate($from, $until) // "yyyy-mm-dd'
    {
        try {
            $start  = $from . " 00:00:00";
            $end = $until . " 00:00:00";
            $statement = $this->pdo->prepare('SELECT * FROM events WHERE start_date >= :start and end_date <= :eind ');
            $statement->bindParam(':start', $start);
            $statement->bindParam(':eind', $end);
            $statement->execute();
            $result_array = $statement->fetchAll(PDO::FETCH_CLASS,__NAMESPACE__ . "\\Event");

            return $result_array;
        } catch
        (PDOException $e) {
            print 'Exception!: ' . $e->getMessage();
        }
    }

    function getEventByPersonAndDate($personID, $from, $until)
    {
        try {

            $start  = $from . " 00:00:00";
            $end = $until . " 00:00:00";

            $statement = $this->pdo->prepare('SELECT * FROM events WHERE event_ownerId = :personid and start_date >= :start and end_date <= :eind');
            $statement->bindParam(':personid', $personID);
            $statement->bindParam(':start',$start);
            $statement->bindParam(':eind', $end);
            $statement->execute();
            $result_array = $statement->fetchAll(PDO::FETCH_CLASS,__NAMESPACE__ . "\\Event");
            return $result_array;

        } catch
        (PDOException $e) {
            print 'Exception!: ' . $e->getMessage();
        }
    }

    function storeEvent($event)
    {
        try {

            $statement = $this->pdo->prepare('INSERT INTO events(title, organiser, start_date, end_date, location, description, invited) VALUES (:title, :organiser, :start_date, :end_date, :location, :description, :invited)');

            $statement->bindParam(':title', $event->title);
            $statement->bindParam(':organiser', $event->organiser);
            $statement->bindParam(':start_date', $event->start_date);
            $statement->bindParam(':end_date', $event->end_date);
            $statement->bindParam(':location', $event->location);
            $statement->bindParam(':description', $event->description);
            $statement->bindParam(':invited', $event->invited);
            $statement->execute();

        } catch
        (PDOException $e) {
            print 'Exception!: ' . $e->getMessage();
        }
    }

    function editEvent($id, $updatedEvent)
    {
        try {
            $statement = $this->pdo->prepare('UPDATE events SET title = :title, organiser = :organiser, start_date = :start_date, end_date = :end_date, location = :location, description = :description, invited = :invited WHERE id = :id');

            $statement->bindParam(':title', $updatedEvent->title);
            $statement->bindParam(':organiser', $updatedEvent->organiser);
            $statement->bindParam(':start_date', $updatedEvent->start_date);
            $statement->bindParam(':end_date', $updatedEvent->end_date);
            $statement->bindParam(':location', $updatedEvent->location);
            $statement->bindParam(':description', $updatedEvent->description);
            $statement->bindParam(':invited', $updatedEvent->invited);
            $statement->bindParam(':id', $id);
            $statement->execute();

        } catch
        (PDOException $e) {
            print 'Exception!: ' . $e->getMessage();
        }
    }

    function deleteEvent($id)
    {
        try {


            $statement = $this->pdo->prepare('DELETE FROM events WHERE id = :id');
            $statement->bindParam(':id',$id);
            $statement->execute();

        } catch
        (PDOException $e) {
            print 'Exception!: ' . $e->getMessage();
        }
    }
}