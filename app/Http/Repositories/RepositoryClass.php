<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\RepositoryInterface;

class RepositoryClass implements RepositoryInterface
{

    public function ShowAll($model, $where)
    {
        // TODO: Implement ShowAll() method.
        return $model::where($where);
    }

    public function Create($model, $arr)
    {
        // TODO: Implement Create() method.
        return $model::create($arr);
    }

    public function ShowById($model, $id)
    {
        // TODO: Implement ShowById() method.
        return $model::find($id);
    }

    public function DeleteById($model, $id)
    {
        // TODO: Implement DeleteById() method.
        return $model::find($id)->delete();
    }


    public function Update($model, $id, $arr)
    {
        // TODO: Implement Update() method.
        return $model::find($id)->update($arr);
    }
}
