<?php

namespace App\Ccu\General;

use App\Ccu\Core\Entity;

class Event extends Entity
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
    protected $visible = ['action', 'detail', 'user_agent', 'ip_address', 'occurred_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'account_id', 'action', 'detail', 'user_agent', 'ip_address', 'occurred_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['occurred_at'];
}