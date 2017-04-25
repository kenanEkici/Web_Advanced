<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Repositories\UserRepository;
use Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function getDecryptedCookie(Request $request)
    {
        return decrypt($request->cookies->get('sessionId'));
    }

    public function login(Request $request)
    {
        $user = $this->users->getByName($request->input('username'));
        $password = $request->input('hash');

        if ($user !== null && $password !== "")
        {
            if ($user->hash === $password)
            {
                $response = new Response("pass");
                return $response->cookie('sessionId', encrypt($user->user_id . '_' . $user->role), 60);
            }
        }
        return "failed";
    }

    public function logout(Request $request)
    {
        return Redirect::to('/login')->withCookie(\Cookie::forget('sessionId'));
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