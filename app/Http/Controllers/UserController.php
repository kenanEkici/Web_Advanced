<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        User::create($request->all());
    }

    public function show($id)
    {
        return User::where('event_id', $id)->get();
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