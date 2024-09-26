<?php

namespace App\Http\Interfaces;

interface RepositoryInterface
{

    public function Create($model, $arr);

    public function ShowAll($model, $where);

    public function ShowById($model, $id);

    public function DeleteById($model, $id);

    public function Update($model, $id, $arr);
}
