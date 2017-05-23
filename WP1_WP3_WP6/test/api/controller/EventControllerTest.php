<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Jan
 * Date: 22/05/2017
 * Time: 15:34
 */

namespace test\api\controller;

use controller\EventController;
use model\Event;
use \PHPUnit\Framework\TestCase;
use PDO;

require_once "vendor\autoload.php";

class EventControllerTest extends TestCase
{
    private $mockEventRepository;

    public function setUp()
    {

        $this->mockEventRepository = $this->getMockBuilder('model\IEventRepository')->getMock();
    }

    public function tearDown()
    {
        $this->mockEventRepository = null;
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
        $event->event_ownerId = intval($variable);
        return $event;

    }

    /**
     * getAllEvents()
     * Testing the getAllEvents with a single element in the database.
     */
    function test_getAllEvents_SingleElementInDatabase_returnsEvent()
    {

        $events = $this->makeEvent("55");

        $this->mockEventRepository->expects($this->atLeastOnce())->method('getAllEvents')->will($this->returnValue($events));

        $EventController = new EventController($this->mockEventRepository);
        $EventController->getAllEvents();

        $this->expectOutputString(sprintf("%s", json_encode($events)));

    }

    /**
     * getAllEvents()
     * Testing the getAllEvents Function with an empty database.
     */
    function test_getAllEvents_EmptyDatabase_returnsNULL()
    {

        $events = null;

        $this->mockEventRepository = $this->getMockBuilder('model\IEventRepository')->getMock();
        $this->mockEventRepository->expects($this->atLeastOnce())->method('getAllEvents')->will($this->returnValue($events));

        $EventController = new EventController($this->mockEventRepository);
        $EventController->getAllEvents();
        $this->expectOutputString(sprintf("%s", "null"));

    }

    /**
     * getAllEvents()
     * Testing if the controller works with multiple elements in database.
     */
    function test_getAllEvents_multipleElementsInDatabase_returnsArrayOfEvents()
    {

        $event1 = $this->makeEvent("1");
        $event2 = $this->makeEvent("2");

        $events = array($event1, $event2);
        $this->mockEventRepository = $this->getMockBuilder('model\IEventRepository')->getMock();
        $this->mockEventRepository->expects($this->atLeastOnce())->method('getAllEvents')->will($this->returnValue($events));


        $EventController = new EventController($this->mockEventRepository);
        $EventController->getAllEvents();


        $this->expectOutputString(sprintf("%s", json_encode($events)));

    }

    /**
     * getEventByID(int $eventID)
     * Testing if the controller returns the event when it exists.
     */
    function test_getEventById_EventFound_returnsEvent()
    {


        $event = $this->makeEvent("10");

        $this->mockEventRepository = $this->getMockBuilder('model\IEventRepository')->getMock();
        $this->mockEventRepository->expects($this->atLeastOnce())->method('getEventByID')->will($this->returnValue($event));

        $EventController = new EventController($this->mockEventRepository);
        $EventController->getEventById(10);
        $this->expectOutputString(sprintf("%s", json_encode($event)));
    }

    /**
     * getEventByID(int $eventID)
     * Testing if the controller returns null when the event does not exist
     */
    function test_getEventById_EventNotFound_returnsErrorString()
    {


        $event = [];

        $this->mockEventRepository = $this->getMockBuilder('model\IEventRepository')->getMock();
        $this->mockEventRepository->expects($this->atLeastOnce())->method('getEventByID')->will($this->returnValue($event));

        $EventController = new EventController($this->mockEventRepository);
        $EventController->getEventById(10);
        $this->expectOutputString(sprintf("%s", "Event Not Found"));
    }

    /**
     * getEventByOwnerID(int $ownerID)
     * Testing if the controller returns the event when it exists.
     */
    function test_getEventByOwnerId_EventFound_returnsEvent()
    {


        $event = $this->makeEvent("10");

        $this->mockEventRepository = $this->getMockBuilder('model\IEventRepository')->getMock();
        $this->mockEventRepository->expects($this->atLeastOnce())->method('getEventByOwnerId')->will($this->returnValue($event));

        $EventController = new EventController($this->mockEventRepository);
        $EventController->getEventsByOwnerId(10);
        $this->expectOutputString(sprintf("%s", json_encode($event)));
    }

    /**
     * getEventByOwnerID(int $ownerID)
     * Testing if the controller returns null when the event does not exist
     */
    function test_getEventByOwnerId_EventNotFound_returnsErrorString()
    {


        $event = [];

        $this->mockEventRepository = $this->getMockBuilder('model\IEventRepository')->getMock();
        $this->mockEventRepository->expects($this->atLeastOnce())->method('getEventByOwnerId')->will($this->returnValue($event));

        $EventController = new EventController($this->mockEventRepository);
        $EventController->getEventsByOwnerId(10);
        $this->expectOutputString(sprintf("%s", "User not found or user does not have any events"));
    }

    /**
     * getEventsByDate($fromDate, $untilDate)
     * Testing if the controller returns a list of events when events are found.
     */
    function test_getEventsByDate_EventsFound_ReturnsListOfEvents()
    {


        $event1 = $this->makeEvent("1");
        $event2 = $this->makeEvent("2");

        $events = array($event1, $event2);
        $this->mockEventRepository = $this->getMockBuilder('model\IEventRepository')->getMock();
        $this->mockEventRepository->expects($this->atLeastOnce())->method('getEventByDate')->will($this->returnValue($events));


        $EventController = new EventController($this->mockEventRepository);
        $EventController->getEventsByDate('2000-01-01', '2020-02-03');


        $this->expectOutputString(sprintf("%s", json_encode($events)));
    }

    /**
     * getEventsByDate($fromDate, $untilDate)
     * Testing if the controller returns "No event found, try another date interval" when the event does not exist
     */
    function test_getEventsByDate_EventNotFound_returnsErrorString()
    {

        $event = [];

        $this->mockEventRepository = $this->getMockBuilder('model\IEventRepository')->getMock();
        $this->mockEventRepository->expects($this->atLeastOnce())->method('getEventByDate')->will($this->returnValue($event));

        $EventController = new EventController($this->mockEventRepository);
        $EventController->getEventsByDate('2017-05-23', '2017-06-01');
        $this->expectOutputString(sprintf("%s", "No event found, try another date interval"));
    }

    /**
     *  getEventsByPersonAndDate($personId, $fromDate, $untilDate)
     * Testing if the controller returns a list of events when there events are found.
     */
    function test_getEventsByPersonAndDate_EventsFound_ReturnsListOfEvents()
    {


        $event1 = $this->makeEvent("1");
        $event2 = $this->makeEvent("2");

        $events = array($event1, $event2);
        $this->mockEventRepository = $this->getMockBuilder('model\IEventRepository')->getMock();
        $this->mockEventRepository->expects($this->atLeastOnce())->method('getEventByPersonAndDate')->will($this->returnValue($events));


        $EventController = new EventController($this->mockEventRepository);
        $EventController->getEventsByPersonAndDate('0', '2000-01-01 15:00', '2020-02-03');

        $this->expectOutputString(sprintf("%s", json_encode($events)));
    }

    /**
     *  getEventsByPersonAndDate($personId, $fromDate, $untilDate)
     * Testing if the controller returns a list of events when there events are found.
     */
    function test_getEventsByPersonAndDate_EventsNotFound_ReturnsErrorString()
    {



        $events = [];
        $this->mockEventRepository = $this->getMockBuilder('model\IEventRepository')->getMock();
        $this->mockEventRepository->expects($this->atLeastOnce())->method('getEventByPersonAndDate')->will($this->returnValue($events));


        $EventController = new EventController($this->mockEventRepository);
        $EventController->getEventsByPersonAndDate('0', '2000-01-01', '2020-02-03');

        $this->expectOutputString(sprintf("%s", "No event found, try other parameters"));
    }

    /**
     * postEvent($newEvent)
     * Testing if the controller returns the amount of lines changed when changing an event.
     */
    function test_PostEvent_EventChanged_ReturnsAmountOfRowsChanged()
    {


        $event1 = $this->makeEvent("1");
        $events = json_encode($event1);
        $this->mockEventRepository = $this->getMockBuilder('model\IEventRepository')->getMock();
        $this->mockEventRepository->expects($this->atLeastOnce())->method('storeEvent')->will($this->returnValue(1));
        $EventController = new EventController($this->mockEventRepository);
        $EventController->postEvent($events);

        $this->expectOutputString(sprintf("%s", '1'));
    }

    /**
     * postEvent($newEvent)
     * Testing if the controller returns an errortext when the new Event can't be added to the database.
     */
    function test_PostEvent_EventNotChanged_ReturnsErrorString()
    {


        $event1 = $this->makeEvent("1");
        $events = json_encode($event1);
        $this->mockEventRepository = $this->getMockBuilder('model\IEventRepository')->getMock();
        $this->mockEventRepository->expects($this->atLeastOnce())->method('storeEvent')->will($this->returnValue(0));


        $EventController = new EventController($this->mockEventRepository);
        $EventController->postEvent($events);

        $this->expectOutputString(sprintf("%s", 'Error while posting the event'));
    }

    /**
     * putEvent($newEvent)
     * Testing if the controller returns the amount of lines changed when changing an event.
     */
    function test_PutEvent_EventChanged_ReturnsAmountOfRowsChanged()
    {


        $event1 = $this->makeEvent("1");
        $events = json_encode($event1);
        $this->mockEventRepository = $this->getMockBuilder('model\IEventRepository')->getMock();
        $this->mockEventRepository->expects($this->atLeastOnce())->method('editEvent')->will($this->returnValue(1));

        $EventController = new EventController($this->mockEventRepository);
        $EventController->putEvent($event1->id, $events);

        $this->expectOutputString(sprintf("%s", '1'));
    }

    /**
     * postEvent($newEvent)
     * Testing if the controller returns an errortext when the new Event can't be added to the database.
     */
    function test_PutEvent_EventNotChanged_ReturnsErrorString()
    {


        $event1 = $this->makeEvent("1");
        $events = json_encode($event1);
        $this->mockEventRepository = $this->getMockBuilder('model\IEventRepository')->getMock();
        $this->mockEventRepository->expects($this->atLeastOnce())->method('editEvent')->will($this->returnValue(0));


        $EventController = new EventController($this->mockEventRepository);
        $EventController->putEvent($event1->id, $events);

        $this->expectOutputString(sprintf("%s", 'Error while updating the event'));
    }

    /**
     * deleteEvent($eventID)
     * Testing if the controller returns the amount of rows changed after deleting the event.
     */
    function test_DeleteEvent_EventChanged_returnsAmountOfRowsChanged(){


        $event1 = $this->makeEvent("1");
        $this->mockEventRepository = $this->getMockBuilder('model\IEventRepository')->getMock();
        $this->mockEventRepository->expects($this->atLeastOnce())->method('deleteEvent')->will($this->returnValue(1));

        $EventController = new EventController($this->mockEventRepository);
        $EventController->deleteEvent($event1->id);

        $this->expectOutputString(sprintf("%s", '1'));
    }

    /**
     * deleteEvent($eventID)
     * Testing if the controller returns an errortext when the event can not be deleted.
     */
    function test_DeleteEvent_EventNotChanged_ReturnsErrorString(){


        $event1 = $this->makeEvent("1");
        $this->mockEventRepository = $this->getMockBuilder('model\IEventRepository')->getMock();
        $this->mockEventRepository->expects($this->atLeastOnce())->method('deleteEvent')->will($this->returnValue(0));


        $EventController = new EventController($this->mockEventRepository);
        $EventController->deleteEvent($event1->id);

        $this->expectOutputString(sprintf("%s", 'Error while deleting the event'));
    }
}
