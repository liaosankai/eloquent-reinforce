<?php

namespace Liaosankai\EloquentReinforce\Traits;

use Illuminate\Database\Eloquent\Model;
use Ulid\Ulid;

trait HasUlidPrimaryKey
{

    public function getIncrementing()
    {
        return false;
    }

    public static function bootHasUlidPrimaryKey()
    {
        static::creating(function (Model $model) {
            if (!isset($model->attributes[$model->getKeyName()])) {
                $model->attributes[$model->getKeyName()] = (string)Ulid::generate();
            }
        });
    }
}