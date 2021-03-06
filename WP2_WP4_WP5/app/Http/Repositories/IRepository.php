<?php
/**
 * Created by PhpStorm.
 * User: Kenan
 * Date: 18/04/2017
 * Time: 13:55
 */

namespace App\Http\Repositories;

//for dependency injection (not injected yet only implemented)
interface IRepository
{
    public function getAll();
    public function getById($id);
    public function getByName($name);
    public function index($searchKey);
    public function store($array,$users);
    public function edit($new, $old_id);
    public function delete($id);
}