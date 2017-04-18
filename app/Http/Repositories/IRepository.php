<?php
/**
 * Created by PhpStorm.
 * User: Kenan
 * Date: 18/04/2017
 * Time: 13:55
 */

namespace app\Http\Repositories;


interface IRepository
{
    public function getAll();
    public function getById($id);
    public function getByName($name);
    public function store($array);
    public function edit($new, $old_id);
    public function delete($id);
    public function assignUserToEvent($event_id,$username);
}