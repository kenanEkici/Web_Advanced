<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Repositories\UserRepository;
use Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    protected $usersRepo;

    public function __construct(UserRepository $users)
    {
        $this->usersRepo = $users;
    }

    //Decrypt cookie waarin de userid in zit
    public function getDecryptedCookie(Request $request)
    {
        return decrypt($request->cookies->get('sessionId'));
    }

    //Login functie
    public function login(Request $request)
    {
        $user = $this->usersRepo->getByName($request->input('username'));
        $password = $request->input('hash');

        //als gebruikersnaam en wachtwoord overeenkomen
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

    //Log uit door cookie te verwijderen en te redirecten naar login pagina
    public function logout(Request $request)
    {
        return Redirect::to('/')->withCookie(\Cookie::forget('sessionId'));
    }

    //POST
    public function store(Request $request)
    {
        //server side validation
        $validation = false;
        $username = $request->input('username');
        $hash = $request->input('hash');
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $address = $request->input('address');

        if (strlen($username) >= 4 && strlen($username) <= 15 && preg_match('/[\^£$%&*()}{@#~?><>,|=_+¬-]/', $username) == 0 ) // min 4kar max 15 nospecchar
        {
            if (strlen($hash) >= 6 && strlen($hash) <= 20 && preg_match('/[\^£$%&*()}{@#~?><>,|=_+¬-]/', $hash) == 0 ) // min 6kar max 20 nospecchar
            {
                if (strlen($first_name) >= 4 && strlen($first_name) <= 20 && preg_match('/[\^£$%&*()}{@#~?><>,|=_+¬-]/', $first_name) == 0  ) // min 4kar max 20 nospecchar
                {
                    if (strlen($last_name) >= 4 && strlen($last_name) <= 40 && preg_match('/[\^£$%&*()}{@#~?><>,|=_+¬-]/', $last_name) == 0  ) // min 4kar max 40 nospecchar
                    {
                         if (strlen($address) >= 4  && strlen($address) <= 100 && preg_match('/[\^£$%&*()}{@#~?><>,|=_+¬-]/', $address) == 0 ) // min 4kar max 100 nospecchar
                         {
                             $validation = true;
                         }
                    }
                }
            }
        }

        //als validation klopt, maak user aan
        if ($validation == true)
        {
            $this->usersRepo->store($request->all(), null);
        }
        else
        {

            var_dump("validation not complete");
            return null;
        }
    }

    //GET BY ID
    public function showById($id)
    {
        return $this->usersRepo->getById($id);
    }

    //GET ALL
    public function showAll()
    {
        return $this->usersRepo->getAll();
    }

    //GET BY USERNAME
    public function showByUsername($username)
    {
        return $this->usersRepo->getByName($username);
    }

    //EDIT
    public function update(Request $request)
    {
        $this->usersRepo->edit($request->input('id'),$request->all());
    }

    //DELETE
    public function destroy(Request $request)
    {
        $this->usersRepo->delete($request->input('id'));
    }

    //GET BY INDEX
    public function searchByIndex($searchKey)
    {
        return $this->usersRepo->index($searchKey);
    }
}