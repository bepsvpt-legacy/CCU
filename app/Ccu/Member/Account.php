<?php

namespace App\Ccu\Member;

use App\Ccu\General\Category;
use App\Ccu\Core\Entity;
use DB;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class Account extends Entity implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, EntrustUserTrait;

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['email', 'user'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'password'];

    /**
     * Get the user data associated with the account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(\App\Ccu\Member\User::class);
    }

    /**
     * Get the account events for the account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(\App\Ccu\General\Event::class)
            ->where('category_id', '=', Category::getCategories('events.account', true));
    }

    /**
     * Save a new model and return the instance.
     *
     * @param  array  $attributes
     * @return static
     */
    public static function create(array $attributes = [])
    {
        DB::beginTransaction();

        $account = parent::create(['email' => $attributes['email'], 'password' => bcrypt($attributes['password'])]);

        if (( ! $account->exists) || ( ! $account->user()->create(['account_id' => $account->getAttribute('id'), 'nickname' => $account->getAttribute('email')])->exists)) {
            DB::rollBack();
        } else {
            DB::commit();
        }

        return $account;
    }
}
