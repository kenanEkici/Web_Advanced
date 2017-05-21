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
        $validation = false;
        $title = $request->input('title');
        $organiser = $request->input('organiser');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $location = $request->input('location');
        $description = $request->input('description');

        if (strlen($title) >= 6 && strlen($title) <= 20) // min 4kar max 15
        {
            if (strlen($organiser) >= 4 && strlen($organiser) <= 15 ) // min 6kar max 20
            {
                if (strlen($startDate) > 0) // chosen
                {
                    if (strlen($endDate) > 0) // chosen
                    {
                        if (strlen($location) >= 4 ) // min 4kar
                        {
                            if (strlen($description) >= 4  && strlen($description) <= 600 ) // min 4kar max 600
                            {
                                $validation = true;
                            }
                        }
                    }

                }
            }
        }
        if ($validation)
        {
            return $this->events->store($request->all(), $request->input('invited'));
        }
        else
        {
            var_dump("invalid validation");
        }
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