<?php

namespace App\Ccu\General;

use App\Ccu\Core\Entity;
use Carbon\Carbon;

class Verify extends Entity
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'token';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['*'];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['token', 'category_id', 'account_id', 'created_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at'];

    /**
     * Get the account of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo('App\Ccu\Member\Account');
    }

    /**
     * Verify the token.
     *
     * @param string $token
     * @return \App\Ccu\Member\Account|string
     */
    public static function verifyToken($token)
    {
        if ((null === ($verify = self::with(['account'])->find($token))) || (false === ($hours = $verify->getExpireHours($verify->getAttribute('category_id')))))
        {
            return '驗證碼不存在';
        }
        else if (Carbon::now() > $verify->getAttribute('created_at')->addHours($hours))
        {
            return '驗證碼已過期';
        }

        $account = $verify->account;

        $verify->delete();

        return $account;
    }

    /**
     * Get token expire hours.
     *
     * @param $category
     * @return bool|int
     */
    public static function getExpireHours($category)
    {
        switch ($category)
        {
            case 3:
                return 6;
            default:
                return false;
        }
    }
}