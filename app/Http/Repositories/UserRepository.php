<?php
/**
 * Created by PhpStorm.
 * User: Kenan
 * Date: 17/04/2017
 * Time: 23:55
 */
namespace App\Http\Repositories;
use App\User;

class UserRepository
{
    public function getAll()
    {
        return User::all();
    }

    public function getById($id)
    {
        return User::where('user_id', $id)->get();
    }

    public function create(Array $array)
    {
        return User::create($array);
    }

    public function update(Request $request, $id)
    {
        echo 'update';
    }

    public function destroy($id)
    {
        User::where('user_id',$id)->destroy();
    }
}