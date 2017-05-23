<?php
require "vendor/autoload.php";

use controller\EventController;
use model\Event;

$router = new AltoRouter();

$user = "web07_db";
$password = "web07";
$database = "web07_db";
$hostname = "213.136.26.180";
$pdo = null;


$pdo = new PDO("mysql:host=$hostname;dbname=$database", $user, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$eventRepository = new \model\EventRepository($pdo);
$eventController = new EventController($eventRepository);

$router->setBasePath('');

//DEFINING ROUTES

//GetAll
$router->map('GET', '/events',
    function () use (&$eventController) {
        $eventController->getAllEvents();

    });

//GetByEventID
$router->map('GET', '/events/[i:eventId]',
    function ($eventId) use (&$eventController) {
        $eventController->getEventById($eventId);

    });

//GetByOwnerID
$router->map('GET', '/events/person/[i:personId]',
    function ($personId) use (&$eventController) {
        $eventController->getEventsByOwnerId($personId);
    });

//GetByPersonAndDate
$router->map('GET', '/events/person/[:personId]/[:fromDate]/[:untilDate]',
    function ($personId, $fromDate, $untilDate) use (&$eventController) {
        $eventController->getEventsByPersonAndDate($personId, $fromDate, $untilDate);
    });

//GetByDate
$router->map('GET', '/events/[:fromDate]/[:untilDate]',
    function ($fromDate, $untilDate) use (&$eventController) {
        $eventController->getEventsByDate($fromDate, $untilDate);
    });

//POST
$router->map('POST', '/events',
    function () use (&$eventController) {
        if (isset($_POST['json']))
        {
            $eventController->postEvent($_POST['json']);
        }
});

//PUT based on eventID and POST.
$router->map('POST', '/events/[i:eventId]',
    function ($eventId) use (&$eventController) {
        $eventController->putEvent($eventId,($_POST['json']));

});

//DELETE based on eventID
$router->map('DELETE', '/events/[i:eventId]',
    function ($eventId) use (&$eventController) {
      $eventController->deleteEvent($eventId);
    });

//GET VIEW
$router->map('GET', '/web/events',
    function(){
    require 'src/api/view/eventsView.php';
    });

$match = $router->match();

if( $match && is_callable( $match['target'] ) ){
	call_user_func_array( $match['target'], $match['params'] );
}
else {
    header("HTTP/1.0 404 Not Found");
}
