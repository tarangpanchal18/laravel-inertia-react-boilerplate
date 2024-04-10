<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\MasterInterface;
use App\Models\Banner;

class BannerRepository implements MasterInterface
{
    public function getAll()
    {
        return Banner::all();
    }

    public function getRaw($filterData = "")
    {
        $query = Banner::query();
        if ($filterData['status']) {
            $query = $query->where('status', $filterData['status']);
        }

        return $query;
    }

    public function getById($id)
    {
        return Banner::findOrFail($id);
    }

    public function delete($id)
    {
        Banner::destroy($id);
    }

    public function create(array $data)
    {
        return Banner::create($data);
    }

    public function update($id, array $newDetails)
    {
        return Banner::whereId($id)->update($newDetails);
    }
}
