<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Repositories\EventRepository;

class EventController extends Controller
{

    protected $eventRepo;

    public function __construct(EventRepository $eventRepo)
    {
        $this->eventRepo = $eventRepo;
    }

    //POST
    public function store(Request $request)
    {
        //server-side validatie van een event
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
        //als validation lukt, maak een nieuwe event aan
        if ($validation)
        {
            return $this->eventRepo->store($request->all(), $request->input('invited'));
        }
        else
        {
            var_dump("invalid validation");
            return null;
        }
    }

    //GET BY ID
    public function showById($id)
    {
        return $this->eventRepo->getById($id);
    }

    //GET ALL
    public function showAll()
    {
        return $this->eventRepo->getAll();
    }

    //GET BY USERNAME
    public function showByUser($username)
    {
        return $this->eventRepo->getByName($username);
    }

    //PUT
    public function update(Request $request)
    {
        $this->eventRepo->edit($request->input('id'),$request->all());
    }

    //DELETE
    public function destroy(Request $request)
    {
        $this->eventRepo->delete($request->input('id'));
    }
}