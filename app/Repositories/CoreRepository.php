<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class CoreRepository
{
    protected $model;

    protected function setModel(Model $model)
    {
        $this->model = $model;
    }

    protected function startConditions()
    {
        return clone $this->model;
    }
}
