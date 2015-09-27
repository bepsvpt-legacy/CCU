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
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PreprocessConnection extends Middleware
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
        if (Agent::isDesktop()) {
            $browser = Agent::browser();

            $version = Agent::version($browser);

            switch ($browser) {
                case 'IE':
                    return $version < 11;
                case 'Firefox':
                    return $version < 38;
                case 'Chrome':
                    return $version < 43;
                case 'Edge':
                case 'Safari':
                    return true;
            }
        }

        return false;
    }

    /**
     * @param \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse $response
     */
    protected function setResponseHeaders($response)
    {
        if ($response instanceof BinaryFileResponse) {
            return;
        }

        $response->header('Content-Security-Policy',
            "style-src *.bepsvpt.net https://cdnjs.cloudflare.com https://maxcdn.bootstrapcdn.com https://cdn.datatables.net 'unsafe-inline';" .
            "script-src *.bepsvpt.net https://cdnjs.cloudflare.com https://www.google.com https://apis.google.com https://ajax.googleapis.com https://www.gstatic.com https://www.google-analytics.com https://cdn.datatables.net " .
            "'sha256-H9EpD3T5JFFGDYAqo8gL2yzG+cfJvNN5Bgs6jVowgDc=';" .
            "frame-ancestors 'self'"
        );
    }
}
