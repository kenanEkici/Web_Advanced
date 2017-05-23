<?php namespace api\model;

/**
 * Created by PhpStorm.
 * User: Pieter-Jan
 * Date: 23/05/2017
 * Time: 19:18
 */


use model\Event;
use model\EventRepository;
use PDO;
use PHPUnit\Framework\TestCase;

require_once "vendor\autoload.php";

class EventRepositoryTest extends TestCase
{
    private $pdo;
    private $_repository;




    /**
     * Test to succesfully store an event in the database.
     */
    function test_StoreEvent_SuccessfullStoredEvent_ReturnsChangedRows()
    {

        //Count the amount of Events
        $EventsCountBefore = sizeof($this->_repository->getAllEvents());

        //Creating a testEvent
        $newEvent = $this->makeEvent("TEST");
        print("test: " . $newEvent->start_date);
        //Posting the event to the table.
        $rowsChanged = $this->_repository->storeEvent($newEvent);

        //Asserting that 1 row has been changed during the posting.
        self::assertEquals(1, $rowsChanged);

        //The size of the DB table after posting the event.
        $EventsCountAfter = sizeof($this->_repository->getAllEvents());

        //Assert that we can get the event from the database based on the ID
        self::assertTrue($EventsCountAfter == ($EventsCountBefore + 1));

        //Deleting the TestEvent
        $this->_repository->deleteEvent($this->getIDOfTestEvent($this->_repository->getAllEvents(), "TEST"));
    }

    /**
     * Test to successfully edit an event in the database
     */
    function test_EditEvent_SuccessfullyEditedEvent_ReturnsChangedRows()
    {

        //Create an event.
        $newEvent = $this->makeEvent("TEST");

        //Store the event
        $rowsChanged = $this->_repository->storeEvent($newEvent);
        self::assertTrue($rowsChanged == 1);

        //GetTheEventID
        $testEventID = $this->getIDOfTestEvent($this->_repository->getAllEvents(), "TEST");

        //Edit the newEvent locally
        $newDescription = "TestDescriptionTest";
        $newEvent->description = $newDescription;

        //EditTheStoredEvent
        $rowsChanged = $this->_repository->editEvent($testEventID, $newEvent);
        self::assertTrue($rowsChanged == 1);

        $editedEventFromDB = $this->_repository->getEventByID($testEventID);

        //AssertDBWIthLocalEditedEvent
        self::assertEquals($editedEventFromDB[0]->description, $newDescription);

        //DeleteEventFromDB
        $this->_repository->deleteEvent($testEventID);
    }

    /**
     * Test to successfully delete an event in the database
     */
    function test_DeleteEvent_SuccessfullyDeletedEvent()
    {
        //Create an event
        $newEvent = $this->makeEvent("TEST");

        //CountBeforeStoring!
        $CountBeforeStoring = sizeof($this->_repository->getAllEvents());

        //Store an event == 1
        $rowChanged = $this->_repository->storeEvent($newEvent);
        self::assertEquals(1, $rowChanged);

        //CountBeforeDeleting
        $CountBeforeDeleting = sizeof($this->_repository->getAllEvents());

        //GetID of the stored event
        $newEventID = $this->getIDOfTestEvent($this->_repository->getAllEvents(), "TEST");

        //Delete the event == 1
        $rowChanged = $this->_repository->deleteEvent($newEventID);
        self::assertEquals(1, $rowChanged);

        //CountAfterDeleting!  == CountBeforeStoring
        $CountAfterDeleting = sizeof($this->_repository->getAllEvents());

        //getEventID(newEventID) == NULL?
        $array = array();
        self::assertEquals($array, $this->_repository->getEventByID($newEventID));
        self::assertEquals($CountAfterDeleting, $CountBeforeDeleting - 1);
        self::assertEquals($CountBeforeStoring,$CountAfterDeleting);

    }

    /**
     * Test to successfully get all the events in the database
     */
    function test_getAllEvents_SuccessfullyGetAllEvents(){

        //Manipulate the datase so the getAllEvents will be

        //GetAllEvents
        $EventsBeforeManipulation = $this->_repository->getAllEvents();
        $CountBeforeManipulation = sizeof($EventsBeforeManipulation);

        //MakeEvent
        $newEvent = $this->makeEvent("TEST");

        //StoreAnEvent
        $rowChanged = $this->_repository->storeEvent($newEvent);
        self::assertEquals(1, $rowChanged);

        //GetIDofEvent
        $eventID = $this->getIDOfTestEvent($this->_repository->getAllEvents(), "TEST");

        //DeleteAnEvent
        $rowChanged = $this->_repository->deleteEvent($eventID);
        self::assertEquals(1, $rowChanged);

        //GetAllEvents
        $EventsAfterManipulation = $this->_repository->getAllEvents();
        $CountAfterManipulation = sizeof($EventsAfterManipulation);

        //Check dat ze gelijk zijn.
        self::assertEquals($EventsBeforeManipulation, $EventsAfterManipulation);
        self::assertEquals($CountBeforeManipulation, $CountAfterManipulation);

    }

    /**
     * Test to successfully get an event by ID if it exists
     */
    function test_getEventByID_SuccessfullyGetEvent(){
        //Create an event
        $newEvent = $this->makeEvent("TEST");

        //add it to the DB
        $rowChanged = $this->_repository->storeEvent($newEvent);
        self::assertEquals(1, $rowChanged);

        //GetIDOfTheNewEvent
        $newEventID = $this->getIDOfTestEvent($this->_repository->getAllEvents(), "TEST");

        //Get the even from the DB by ID.
        $eventFromDB = $this->_repository->getEventByID($newEventID);
        self::assertEquals([$eventFromDB[0]->title, $eventFromDB[0]->start_date], [$newEvent->title,$newEvent->start_date]);

        //Delete the test event
        $rowChanged = $this->_repository->deleteEvent($newEventID);
        self::assertEquals(1, $rowChanged);
    }


    /**
     * Test to successfully get an event between Dates
     */
    function test_getEventByOwnerID_SuccessfullyGetEvent(){
        //Make new event
        $newEvent = $this->makeEvent("TEST");

        //store the new event
        $rowChanged = $this->_repository->storeEvent($newEvent);
        self::assertEquals(1, $rowChanged);

        //get the event by ownerID
        $eventFromDB = $this->_repository->getEventByOwnerId($newEvent->event_ownerId);

        $count = sizeof($this->_repository->getAllEvents());
        //Assert if it is the same event
        self::assertEquals([$newEvent->title, $newEvent->start_date], [$eventFromDB[$count-1]->title, $eventFromDB[$count-1]->start_date]);
    }

    /**
     * Helper functions
     */
    protected function setUp()
    {
        $user = "web07_db";
        $password = "web07";
        $database = "web07_db";
        $hostname = "213.136.26.180";
        $pdo = null;


        $this->pdo = new PDO("mysql:host=$hostname;dbname=$database", $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->_repository = new EventRepository($this->pdo);
    }

    public function makeEvent($variable)
    {
        $event = new Event();
        $event->invited = "invited" . $variable;
        $event->id = intval($variable);
        $event->description = "description" . $variable;
        $event->location = "location" . $variable;
        $event->end_date = date('Y-m-d H:i:s');
        $event->start_date = date('Y-m-d H:i:s');
        $event->organiser = "organiser" . $variable;
        $event->title = "title" . $variable;
        $event->event_ownerId = 0;
        return $event;

    }

    public function getIDOfTestEvent($Events, $var)
    {
        foreach ($Events as $event) {
            if ($event->title == ("title" . $var)) {
                return $event->id;
            }
        }

    }
}
