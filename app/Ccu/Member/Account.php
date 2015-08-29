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
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['user'];

    /**
     * Get the user data associated with the account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\Ccu\Member\User');
    }

    /**
     * Get the account events for the account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        $event = Category::getCategories('events.account')->shift();

        return $this->hasMany('App\Ccu\General\Event')
            ->where('category_id', '=', $event->getAttribute('id'));
    }

    public static function create(array $attributes = [])
    {
        DB::beginTransaction();

        $account = parent::create(['email' => $attributes['email'], 'password' => bcrypt($attributes['password'])]);

        if (( ! $account->exists) || ( ! $account->user()->create(['account_id' => $account->getAttribute('id'), 'nickname' => $account->getAttribute('email')])->exists))
        {
            DB::rollBack();
        }
        else
        {
            DB::commit();
        }

        return $account;
    }
}