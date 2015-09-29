<?php

if ( ! function_exists('_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string $path
     * @param  bool $secure
     * @param  bool $absolute
     * @return string
     */
    function _asset($path, $secure = null, $absolute = false)
    {
        $url = asset($path, $secure);

        return $absolute ? $url : str_replace(env('APPLICATION_URL'), '', $url);
    }
}

if ( ! function_exists('_route')) {
    /**
     * Generate a URL to a named route.
     *
     * @param  string $name
     * @param  bool $appendVersion
     * @return string
     */
    function routeAssets($name, $appendVersion = false)
    {
        $postfix = ['js' => '.js', 'templates' => '.html', 'css' => '.css'][strstr($name, '.', true)];

        $url = 'assets/' . str_replace('.', '/', $name) . $postfix;

        return _asset($url) . ($appendVersion ? ('?v=' . \App\Ccu\Core\Entity::VERSION) : '');
    }
}

if ( ! function_exists('temp_path')) {
    /**
     * Get the path to the temporary folder.
     *
     * @param  string  $path
     * @return string
     */
    function temp_path($path = '')
    {
        return custom_path(storage_path('temp'), $path);
    }
}

if ( ! function_exists('cdn_path')) {
    /**
     * Get the path to the cdn folder.
     *
     * @param  string  $path
     * @return string
     */
    function cdn_path($path = '')
    {
        return custom_path(base_path('../cdn'), $path);
    }
}

if ( ! function_exists('image_path')) {
    /**
     * Get the path to the image folder.
     *
     * @param  int $hash
     * @param  int $timestamp
     * @param  bool $thumbnail
     * @return string
     */
    function image_path($hash, $timestamp, $thumbnail = false)
    {
        // 基本路徑
        $path = 'uploads/images';

        // 縮圖路徑
        if ($thumbnail) {
            $path .= '/thumbnails';
        }

        // 以時間前三位作為目錄分隔，以免單一目錄過多檔案
        $path .= '/' . substr($timestamp, 0, 3) . "/{$hash}-{$timestamp}";

        return custom_path(storage_path(), $path);
    }
}

if ( ! function_exists('default_avatar_path')) {
    /**
     * Get the path to the default avatar.
     *
     * @return string
     */
    function default_avatar_path()
    {
        return custom_path(storage_path(), 'uploads/images/default_avatar.jpg');
    }
}

if ( ! function_exists('custom_path')) {
    /**
     * Transform path according to operating system.
     *
     * @param  string $base
     * @param  string $addition
     * @return string
     */
    function custom_path($base, $addition = '')
    {
        if ($addition) {
            // 如果 $addition 有值，則附加在 $base 後面
            $base .= DIRECTORY_SEPARATOR . $addition;
        }

        // 將路徑中的 「/」 或 「\」 根據系統轉換成對應分隔符號後回傳
        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $base);
    }
}

if ( ! function_exists('virustotal_link_to_id')) {
    /**
     * Convert VirusTotal permalink to id.
     *
     * @param  string $link
     * @return string
     */
    function virustotal_link_to_id($link)
    {
        $spilt = explode('/', strstr($link, 'file'));

        return "{$spilt[1]}-{$spilt[3]}";
    }
}
