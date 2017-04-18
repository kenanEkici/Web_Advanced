<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\UserRepository;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function store(Request $request)
    {
        $this->users->store($request->all());
    }

    public function showById($id)
    {
        return $this->users->getById($id);
    }

    public function showAll()
    {
        return $this->users->getAll();
    }

    public function showByUsername($username)
    {
        return $this->users->getByName($username);
    }

    public function update(Request $request)
    {
        $this->users->edit($request->input('user_id'),$request->all());
    }

    public function destroy(Request $request)
    {
        $this->users->delete($request->input('user_id'));
    }

    public function assign(Request $request)
    {
        $this->users->assignUserToEvent($request->input('username'),$request->input('event_id'));
    }
}