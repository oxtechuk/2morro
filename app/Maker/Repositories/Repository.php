<?php

namespace Abedin\Maker\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    /**
     * @abstract
     */
    abstract public static function model();

    /**
     * @return Builder
     */
    public static function query(): Builder
    {
        return static::model()::query();
    }

    /**
     * @return Collection
     */
    public static function getAll(): Collection
    {
        return static::model()::latest()->get();
    }

    /**
     * @return int
     */
    public static function countAll(): int
    {
        return static::model()::count();
    }

    /**
     * @return Model|null
     */
    public static function first(): Model|null
    {
        return static::query()->first();
    }

    /**
     * @param mixed $primaryKey
     * @return Model|null
     */
    public static function find($primaryKey): Model|null
    {
        return static::query()->find($primaryKey);
    }

    /**
     * @param mixed $primaryKey
     * @return Model
     */
    public static function findOrFail($primaryKey)
    {
        return static::query()->findOrFail($primaryKey);
    }

    /**
     * @param mixed $primaryKey
     * @return bool
     */
    public static function delete($primaryKey): bool
    {
        return (bool) static::model()::destroy($primaryKey);
    }

    /**
     * @param array $data
     * @return Model
     */
    public static function create(array $data): Model
    {
        return static::query()->create($data);
    }

    /**
     * @param Model $model
     * @param array $data
     * @return bool
     */
    public static function update(Model $model, array $data): bool
    {
        return (bool) $model->update($data);
    }
}
