<?php

namespace App\Ccu\Member;

use App\Ccu\Core\Entity;

class User extends Entity
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'account_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['nickname', 'profilePicture', 'votes'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['account_id', 'nickname', 'profile_picture_id'];

    /**
     * Get the account of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(\App\Ccu\Member\Account::class);
    }

    /**
     * Get the profile picture of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profilePicture()
    {
        return $this->belongsTo(\App\Ccu\Image\Image::class, 'profile_picture_id');
    }

    /**
     * Get the votes associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes()
    {
        return $this->hasMany(\App\Ccu\Course\CommentsVote::class);
    }
}
