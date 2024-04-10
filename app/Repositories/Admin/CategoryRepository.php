<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\MasterInterface;
use App\Models\Category;

class CategoryRepository implements MasterInterface
{
    public function getAll()
    {
        return Category::all();
    }

    /**
     * @param int $except [Single Id to be ignored]
     */
    public function getParentCategory($igore = '')
    {
        $data = Category::whereNull('parent_id');
        if ($igore) {
            $data->where('id', '!=', $igore);
        }

        return $data->get();
    }

    public function getRaw($filterData = "")
    {
        $query = Category::query();
        if ($filterData['status']) {
            $query = $query->where('status', $filterData['status']);
        }
        if ($filterData['category']) {
            $query = $query->where('parent_id', $filterData['category']);
        }

        return $query;
    }

    public function getById($id)
    {
        return Category::findOrFail($id);
    }

    public function delete($id)
    {
        Category::destroy($id);
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function update($id, array $newDetails)
    {
        return Category::whereId($id)->update($newDetails);
    }
}
