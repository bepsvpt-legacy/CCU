<?php

namespace App\Ccu\Core;

use Eloquent;

class Entity extends Eloquent
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