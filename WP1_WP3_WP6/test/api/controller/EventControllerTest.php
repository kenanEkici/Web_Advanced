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
use PDO;

require_once "vendor\autoload.php";

class EventControllerTest extends \PHPUnit\Framework\TestCase
{
    private $mockEventRepository;


    public function setUp()
    {
        //$this->mockEventRepository = $this->getMockBuilder('model\EventRepository')->getMock();
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
        $user = "web07_db";
        $password = "web07";
        $database = "web07_db";
        $hostname = "213.136.26.180";
        $pdo = null;


        $pdo = new PDO("mysql:host=$hostname;dbname=$database", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $events = $this->makeEvent("55");

        $this->mockEventRepository = $this->getMockBuilder('model\IEventRepository')->getMock();
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
        $user = "web07_db";
        $password = "web07";
        $database = "web07_db";
        $hostname = "213.136.26.180";
        $pdo = null;


        $pdo = new PDO("mysql:host=$hostname;dbname=$database", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
        $user = "web07_db";
        $password = "web07";
        $database = "web07_db";
        $hostname = "213.136.26.180";
        $pdo = null;
        $pdo = new PDO("mysql:host=$hostname;dbname=$database", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
        $user = "web07_db";
        $password = "web07";
        $database = "web07_db";
        $hostname = "213.136.26.180";
        $pdo = null;


        $pdo = new PDO("mysql:host=$hostname;dbname=$database", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
    function test_getEventById_EventNotFound_returnsEventNotFoundString()
    {
        $user = "web07_db";
        $password = "web07";
        $database = "web07_db";
        $hostname = "213.136.26.180";
        $pdo = null;


        $pdo = new PDO("mysql:host=$hostname;dbname=$database", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
        $user = "web07_db";
        $password = "web07";
        $database = "web07_db";
        $hostname = "213.136.26.180";
        $pdo = null;


        $pdo = new PDO("mysql:host=$hostname;dbname=$database", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
    function test_getEventByOwnerId_EventNotFound_returnsEventNotFoundString()
    {
        $user = "web07_db";
        $password = "web07";
        $database = "web07_db";
        $hostname = "213.136.26.180";
        $pdo = null;


        $pdo = new PDO("mysql:host=$hostname;dbname=$database", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $event = [];

        $this->mockEventRepository = $this->getMockBuilder('model\IEventRepository')->getMock();
        $this->mockEventRepository->expects($this->atLeastOnce())->method('getEventByOwnerId')->will($this->returnValue($event));

        $EventController = new EventController($this->mockEventRepository);
        $EventController->getEventsByOwnerId(10);
        $this->expectOutputString(sprintf("%s", "User not found or user does not have any events"));
    }


    /**
     * getEventBetweenDatzes(int $ownerID)
     *
     */
    function test_getEventsBetweenDates_EventNotFound_returns()

}
