<?php

namespace App\Ccu\General;

use App\Ccu\Core\Entity;
use Carbon\Carbon;
use Request;

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

    /**
     * Save a new model and return the instance.
     *
     * @param  array  $attributes
     * @return static
     */
    public static function create(array $attributes = [])
    {
        $attributes['user_agent'] = Request::header('user-agent');
        $attributes['ip_address'] = Request::ip();
        $attributes['occurred_at'] = Carbon::now();

        return parent::create($attributes);
    }
}