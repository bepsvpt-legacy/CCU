<?php

namespace App\Http\Middleware;

use Agent;
use App\Ccu\Core\Entity;
use Carbon\Carbon;
use Closure;
use Illuminate\Auth\Guard;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PreprocessConnection
{
    /**
     * @var Guard
     */
    protected $guard;

    /**
     * @var ViewFactory
     */
    protected $view;

    /**
     * The URIs that should be excluded from browser detection.
     *
     * @var array
     */
    protected $browserDetectionExcept = [
        'errors/*',
    ];

    /**
     * @param Guard $guard
     * @param ViewFactory $view
     */
    public function __construct(Guard $guard, ViewFactory $view)
    {
        $this->guard = $guard;

        $this->view = $view;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Carbon::setLocale('zh-TW');

        if (( ! $this->shouldPassThrough($request, $this->browserDetectionExcept)) && $this->isBrowserNotSupport()) {
            return redirect()->route('errors.browserNotSupport');
        }

        $this->setGlobalViewVariables();

        $response = $next($request);

        $this->setResponseHeaders($response);

        return $response;
    }

    protected function setGlobalViewVariables()
    {
        $this->view->share('guard', $this->guard);

        $this->view->share('version', Entity::VERSION);
    }

    /**
     * Determine if the user browser is not support.
     *
     * @return bool
     */
    protected function isBrowserNotSupport()
    {
        $browser = Agent::browser();

        $version = Agent::version($browser);

        switch ($browser) {
            case 'IE':
                return $version < 11;
            case 'Firefox':
                return $version < 38;
            case 'Chrome':
                return $version < 43;
        }

        return false;
    }

    /**
     * @param \Illuminate\Http\Response $response
     */
    protected function setResponseHeaders($response)
    {
        $response->header('Content-Security-Policy',
            "style-src *.bepsvpt.net https://cdnjs.cloudflare.com https://maxcdn.bootstrapcdn.com 'unsafe-inline';" .
            "script-src *.bepsvpt.net https://cdnjs.cloudflare.com https://www.google.com https://www.gstatic.com " .
            "'sha256-" . base64_encode(hash('sha256', 'const VERSION = ' . Entity::VERSION . ';', true)) . "' " .
            "'sha256-H9EpD3T5JFFGDYAqo8gL2yzG+cfJvNN5Bgs6jVowgDc=';" .
            "frame-ancestors 'self'"
        );
    }

    /**
     * Determine if the request has a URI that should pass through browser detection.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  array $excepts
     * @return bool
     */
    protected function shouldPassThrough($request, array $excepts = [])
    {
        foreach ($excepts as $except) {
            if ($request->is($except)) {
                return true;
            }
        }

        return false;
    }
}
