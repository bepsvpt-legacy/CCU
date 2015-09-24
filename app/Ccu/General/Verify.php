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
        return $this->belongsTo(\App\Ccu\Member\Account::class);
    }

    /**
     * Verify the token.
     *
     * @param string $token
     * @return \App\Ccu\Member\Account|string
     */
    public static function verifyToken($token)
    {
        $verify = self::with(['account'])->find($token);

        if (null === $verify) {
            return '驗證碼不存在';
        }

        $hours = $verify->getExpireHours($verify->getAttribute('category_id'));

        if (false === $hours) {
            return '驗證碼資料異常，請聯繫管理員協助處理';
        } else if (Carbon::now() > $verify->getAttribute('created_at')->addHours($hours)) {
            return '驗證碼已過期';
        }

        $verify->delete();

        return $verify->getRelation('account');
    }

    /**
     * Get token expires hours.
     *
     * @param $categoryId
     * @return bool|int
     */
    public static function getExpireHours($categoryId)
    {
        $categories = Category::getCategories();

        $category = $categories->search(function ($item) use ($categoryId) {
            return $item->getAttribute('id') === $categoryId;
        });

        return (false !== $category)
            ? json_decode($categories[$category]->getAttribute('name'))->{'expireHours'}
            : false;
    }
}
