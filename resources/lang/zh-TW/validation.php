<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => '您必須接受 :attribute',
    'active_url'           => ':attribute 並非一個有效的網址',
    'after'                => ':attribute 必須要在 :date 之後',
    'alpha'                => ':attribute 僅能由英文字母組成',
    'alpha_dash'           => ':attribute 僅能由英文字母、數字和底線組成',
    'alpha_num'            => ':attribute 僅能由英文字母和數字組成',
    'array'                => ':attribute 必須為陣列',
    'before'               => ':attribute 必須要在 :date 之前',
    'between'              => [
        'numeric' => ':attribute 值必須介於 :min 至 :max 之間',
        'file'    => ':attribute 大小必須介乎 :min KB 至 :max KB 之間',
        'string'  => ':attribute 長度必須介於 :min 至 :max 之間',
        'array'   => ':attribute 必須有 :min 至 :max 個元素',
    ],
    'boolean'              => ':attribute 必須為 Boolean 值',
    'confirmed'            => ':attribute 確認欄位的值不相符',
    'date'                 => ':attribute 並非一個有效的日期',
    'date_format'          => ':attribute 與 :format 格式不相符',
    'different'            => ':attribute 與 :other 必須不同',
    'digits'               => ':attribute 必須是 :digits 位數字',
    'digits_between'       => ':attribute 必須介乎 :min 至 :max 位數字',
    'email'                => ':attribute 格式錯誤',
    'filled'               => ':attribute 不能留空',
    'exists'               => ':attribute 不是有效的值',
    'image'                => ':attribute 必須是一張圖片',
    'in'                   => ':attribute 不是有效的值',
    'integer'              => ':attribute 必須是一個整數',
    'ip'                   => ':attribute 必須是一個有效的 IP 位址',
    'max'                  => [
        'numeric' => ':attribute 值不能大於 :max.',
        'file'    => ':attribute 大小不能大於 :max KB',
        'string'  => ':attribute 長度不能大於 :max 個字',
        'array'   => ':attribute 最多有 :max 個元素',
    ],
    'mimes'                => ':attribute 必須為 :values 的檔案',
    'min'                  => [
        'numeric' => ':attribute 值不能小於 :min.',
        'file'    => ':attribute 大小不能小於 :min KB',
        'string'  => ':attribute 長度不能小於 :min 個字',
        'array'   => ':attribute 至少需 :min 個元素',
    ],
    'not_in'               => ':attribute 不是有效的值',
    'numeric'              => ':attribute 必須為一個數字',
    'regex'                => ':attribute 的格式錯誤',
    'required'             => ':attribute 不能留空',
    'required_if'          => '當 :other 是 :value 時 :attribute 不能留空',
    'required_with'        => '當 :values 出現時 :attribute 不能留空',
    'required_with_all'    => '當 :values 出現時 :attribute 不能為空',
    'required_without'     => '當 :values 留空時 :attribute field 不能留空',
    'required_without_all' => '當 :values 都不出現時 :attribute 不能留空',
    'same'                 => ':attribute 與 :other 必須一致',
    'size'                 => [
        'numeric' => ':attribute 值必須是 :size',
        'file'    => ':attribute 大小必須是 :size KB',
        'string'  => ':attribute 長度必須是 :size',
        'array'   => ':attribute 必須是 :size 個元素',
    ],
    'string'               => ':attribute 必須是一個字串',
    'timezone'             => ':attribute 並非一個有效的時區',
    'unique'               => ':attribute 已經存在',
    'url'                  => ':attribute 並非一個有效的網址',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

    'recaptcha' => '糟了，人類驗證沒通過，再試一次吧~',

];
