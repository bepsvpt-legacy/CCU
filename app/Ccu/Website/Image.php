<?php

namespace App\Ccu\Website;

use App\Ccu\Core\Entity;

class Image extends Entity
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['hash_1', 'hash_2'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['hash_1', 'hash_2', 'mime_type'];
}