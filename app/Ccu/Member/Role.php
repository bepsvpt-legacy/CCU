<?php

namespace App\Ccu\Member;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'display_name', 'description'];

    /**
     * Many-to-Many relations with the user model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('Ccu\Ccu\Member\Account', config('entrust.role_user_table'), 'role_id', 'user_id');
    }

    /**
     * Get the permissions for the role.
     *
     * @return array
     */
    public function getPermissionListAttribute()
    {
        return $this->perms->lists('id')->all();
    }
}