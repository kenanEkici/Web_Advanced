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
                return $response->cookie('sessionId', encrypt($user->id), 60);
            }
        }
        return "failed";
    }

    public function logout(Request $request)
    {
        return Redirect::to('/')->withCookie(\Cookie::forget('sessionId'));
    }

    //server side validation
    public function store(Request $request)
    {
        //$validation = false;
//
//        if (strlen($request->input('username')) > 6) //langer dan 6 karakters
//        {
//            if (strlen($request->input('hash')) > 6) //langer dan 6 karakters
//            {
//                if (strlen($request->input('first_name')) > 2 ) //niet leeg
//                {
//                    if (strlen($request->input('last_name')) > 2 ) //niet leeg
//                    {
//                        if (strlen($request->input('role'))> 2 ) //niet leeg
//                        {
//                            if (strlen($request->input('address')) > 2 ) //niet leeg
//                            {
//                                $validation = true;
//                            }
//                        }
//                    }
//                }
//            }
//        }
//
//        if ($validation == true)
//        {
//            $this->users->store($request->all());
//        }
//        else
//        {
//            return $validation+"";
//        }
        $this->users->store($request->all(),null);
//        return response()->json(['name' => $validation]);

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
        $this->users->edit($request->input('id'),$request->all());
    }

    public function destroy(Request $request)
    {
        $this->users->delete($request->input('id'));
    }


    public function searchByIndex($searchKey)
    {
        return $this->users->index($searchKey);
    }
}