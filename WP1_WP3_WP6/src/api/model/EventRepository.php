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

    // get events by it from the database
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

    //get events by owner id from the database
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

    // get events by date from the database
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

    // get events by person and date from the database
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

    // POST event into Database
    function storeEvent($event)
    {
        try {
            $statement = $this->pdo->prepare('INSERT INTO events(title, organiser, start_date, end_date, location, description, invited) VALUES (:title, :organiser, :start_date, :end_date, :location, :description, :invited)');


            $startDate = $event->start_date . " 00:00:00";
            $endDate = $event->end_date . " 00:00:00";

            $statement->bindParam(':title', $event->title);
            $statement->bindParam(':organiser', $event->organiser);
            $statement->bindParam(':start_date', $startDate);
            $statement->bindParam(':end_date', $endDate);
            $statement->bindParam(':location', $event->location);
            $statement->bindParam(':description', $event->description);
            $statement->bindParam(':invited', $event->invited);
            return $statement->execute();

        } catch
        (PDOException $e) {
            print 'Exception!: ' . $e->getMessage();
        }
    }

    // PUT == Change event in the database by id
    function editEvent($id, $updatedEvent)
    {
        try {
            $statement = $this->pdo->prepare('UPDATE events SET title = :title, organiser = :organiser, start_date = :start_date, end_date = :end_date, location = :location, description = :description, invited = :invited WHERE id = :id');

            $startDate = $updatedEvent->start_date . " 00:00:00";
            $endDate = $updatedEvent->end_date ." 00:00:00";

            $statement->bindParam(':title', $updatedEvent->title);
            $statement->bindParam(':organiser', $updatedEvent->organiser);
            $statement->bindParam(':start_date', $startDate);
            $statement->bindParam(':end_date', $endDate);
            $statement->bindParam(':location', $updatedEvent->location);
            $statement->bindParam(':description', $updatedEvent->description);
            $statement->bindParam(':invited', $updatedEvent->invited);
            $statement->bindParam(':id', $id);
            return $statement->execute();

        } catch
        (PDOException $e) {
            print 'Exception!: ' . $e->getMessage();
        }
    }

    // Delete event from database
    function deleteEvent($id)
    {
        try {


            $statement = $this->pdo->prepare('DELETE FROM events WHERE id = :id');
            $statement->bindParam(':id',$id);
            return $statement->execute();

        } catch
        (PDOException $e) {
            print 'Exception!: ' . $e->getMessage();
        }
    }
}