<?php

namespace App\Ccu\Dormitories;

use App\Ccu\Core\Entity;

class Roommate extends Entity
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dormitories_roommates';

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['room', 'bed', 'name', 'fb'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['academic', 'room', 'bed', 'name', 'fb'];
}