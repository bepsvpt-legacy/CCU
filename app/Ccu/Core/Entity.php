<?php

namespace App\Ccu\Core;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    const CACHE_A_DAY = 1440;

    const CACHE_A_WEEK = 10080;

    const CACHE_A_MONTH = 43200;

    /**
     * Get the table name of this model.
     *
     * @return string
     */
    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}