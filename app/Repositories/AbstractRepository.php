<?php

namespace App\Repositories;

abstract class AbstractRepository
{
    /**
     * An instance of the Eloquent model
     *
     * @var Model
     */
    protected $model;

    /**
     * Find a model
     *
     * @var int
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Find or fail a model
     *
     * @var int
     */
    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }
}