<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return Event::all();
    }

    public function store(Request $request)
    {
        Event::create($request->all());
    }

    public function show($id)
    {
        return Event::where('event_id', $id)->get();
    }

    public function update(Request $request, $id)
    {
        echo 'update';
    }

    public function destroy($id)
    {
        Event::where('event_id',$id)->destroy();
    }
}