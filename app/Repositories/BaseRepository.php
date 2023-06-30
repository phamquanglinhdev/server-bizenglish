<?php

namespace App\Repositories;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    private Model $model;

    public abstract function getModelClass(): string;

    /**
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->setClass();
    }

    /**
     * @throws BindingResolutionException
     */
    public function setClass(): void
    {
        $this->model = app()->make($this->getModelClass());
    }

    public function getBuilder(): Builder
    {
        return $this->model->newQuery();
    }
}
