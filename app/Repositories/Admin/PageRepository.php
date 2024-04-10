<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\MasterInterface;
use App\Models\Page;

class PageRepository implements MasterInterface
{
    public function getAll()
    {
        return Page::all();
    }

    public function getRaw($filterData = "")
    {
        $query = Page::query();
        if ($filterData['status']) {
            $query = $query->where('status', $filterData['status']);
        }

        return $query;
    }

    public function getById($id)
    {
        return Page::findOrFail($id);
    }

    public function delete($id)
    {
        Page::destroy($id);
    }

    public function create(array $data)
    {
        return Page::create($data);
    }

    public function update($id, array $newDetails)
    {
        return Page::whereId($id)->update($newDetails);
    }
}
