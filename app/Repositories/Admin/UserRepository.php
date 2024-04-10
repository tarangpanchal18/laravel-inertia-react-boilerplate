<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\MasterInterface;
use App\Models\User;

class UserRepository implements MasterInterface
{
    public function getAll()
    {
        return User::all();
    }

    public function getRaw($filterData = "")
    {
        $query = User::query();
        if ($filterData['status']) {
            $query = $query->where('status', $filterData['status']);
        }

        return $query;
    }

    public function getById($id)
    {
        return User::findOrFail($id);
    }

    public function delete($id)
    {
        User::destroy($id);
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update($id, array $newDetails)
    {
        return User::whereId($id)->update($newDetails);
    }
}
