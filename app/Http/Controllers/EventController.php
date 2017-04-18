<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use App\Http\Repositories\EventRepository;

class EventController extends Controller
{

    protected $events;

    public function __construct(EventRepository $events)
    {
        $this->events = $events;
    }

    public function store(Request $request)
    {
        $this->events->store($request->all());
    }

    public function showById($id)
    {
        return $this->events->getById($id);
    }

    public function showAll()
    {
        return $this->events->getAll();
    }

    public function showByUsername($name)
    {
        return $this->events->getByName($name);
    }

    public function update(Request $request)
    {
        $this->events->edit($request->all(), $request->input('event_id'));
    }

    public function destroy($id)
    {
        $this->events->delete($id);
    }
}