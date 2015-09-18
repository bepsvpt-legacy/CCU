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
        $url = app('url')->asset($path, $secure);

        if ($absolute) {
            return $url;
        }

        return str_replace(env('APPLICATION_URL'), '', $url);
    }
}

if ( ! function_exists('_route')) {
    /**
     * Generate a URL to a named route.
     *
     * @param  string  $name
     * @return string
     */
    function routeAssets($name)
    {
        $postfix = ['js' => '.js', 'templates' => '.html', 'css' => '.css'][strstr($name, '.', true)];

        $url = 'assets/' . str_replace('.', '/', $name) . $postfix;

        return _asset($url);
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
        return storage_path('temp') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
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
        return realpath(base_path('..' . DIRECTORY_SEPARATOR . 'cdn')) . ($path ? DIRECTORY_SEPARATOR . $path : $path);
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
        $path = 'uploads' . DIRECTORY_SEPARATOR . 'images';

        // 縮圖路徑
        if ($thumbnail) {
            $path .= DIRECTORY_SEPARATOR . 'thumbnails';
        }

        // prefix 路徑，以免當目錄過多檔案
        $path .= DIRECTORY_SEPARATOR . substr($timestamp, 0, 3);

        // 圖片名稱
        $path .= DIRECTORY_SEPARATOR . "{$hash}-{$timestamp}";

        return storage_path($path);
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
        return storage_path('uploads/images/default_avatar.jpg');
    }
}
