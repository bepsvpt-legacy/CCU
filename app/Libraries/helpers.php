<?php

if ( ! function_exists('_asset'))
{
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

        if ($absolute)
        {
            return $url;
        }

        return str_replace(env('APPLICATION_URL'), '', $url);
    }
}

if ( ! function_exists('_route'))
{
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

if ( ! function_exists('temp_path'))
{
    /**
     * Get the path to the temporary folder.
     *
     * @param  string  $path
     * @return string
     */
    function temp_path($path = '')
    {
        return base_path('../temp') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}