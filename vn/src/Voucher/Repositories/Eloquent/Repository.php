<?php

namespace Vanhack\Voucher\Repositories\Eloquent;

use Vanhack\Voucher\Repositories\Contracts\RepositoryInterface;
use Vanhack\Voucher\Repositories\Exceptions\RepositoryException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

abstract class Repository implements RepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->makeModel();
    }

    /***
     * Return Model name of child class
     * @return mixed
     */
    abstract protected function model();

    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'))
    {
        return $this->model->get($columns);
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*'))
    {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute = "id")
    {
        return $this->model->where($attribute, '=', $id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'))
    {
        return $this->model->find($id, $columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*'))
    {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findAllBy($attribute, $value, $columns = array('*'))
    {
        return $this->model->where($attribute, '=', $value)->get($columns);
    }

    /**
     * Queries a model with another relationship given a criteria.
     *
     * @param $with
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findWith($with, $attribute, $value, $columns = array('*'))
    {
        return $this->model->with($with)->where($attribute, '=', $value)->get($columns);
    }

    /**
     * Queries a model with another relationship given a criteria.
     *
     * @param $with
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findFirstWith($with, $attribute, $value, $columns = array('*'))
    {
        return $this->model->with($with)->where($attribute, '=', $value)->first($columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function firstOrCreate(array $data)
    {
        return $this->model->firstOrCreate($data);
    }

    /**
     * @return Model
     * @throws RepositoryException
     */
    public function makeModel()
    {
        $model = $this->model();

        if (!$model instanceof Model) {
            throw new RepositoryException("Class {$this->model()} must be an instance of
            Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * Eager Loading using with.
     *
     * @param $relationship
     * @return mixed
     */
    public function with($relationship)
    {
        $model = $this->model();
        return $model::with($relationship)->get();
    }

    /**
     * Eager Load using with for first result.
     *
     * @param $relationship
     * @return mixed
     */
    public function firstWith($relationship)
    {
        $model = $this->model();
        return $model::with($relationship)->first();
    }

    /**
     * Inserts into table
     * @param $data
     * @return mixed
     */
    public function insert(array $data)
    {
        $model = $this->model();
        return $model::insert($data);
    }
}
