<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function list()
    {
        $items = User::get();
        return $items;
    }

    public function find($id)
    {
        $item = User::findOrFail($id);
        return $item;
    }

    public function create($data = [])
    {
        $item = new User($data);
        $item->save();
        return $item;
    }

    public function update($id, $data = [])
    {
        $item = User::find($id);
        $item->update($data);
        return $item;
    }

    public function delete($id)
    {
        $item = User::findOrFail($id);
        $item->delete();
    }
}
