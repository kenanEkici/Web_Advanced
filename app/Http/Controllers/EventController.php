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
        return $this->events->store($request->all(), $request->input('invited'));
    }

    public function showById($id)
    {
        return $this->events->getById($id);
    }

    public function showAll()
    {
        return $this->events->getAll();
    }

    public function showByUser($username)
    {
        return $this->events->getByName($username);
    }

    public function update(Request $request)
    {
        $this->events->edit($request->input('id'),$request->all());
    }

    public function destroy(Request $request)
    {
        $this->events->delete($request->input('id'));
    }
}