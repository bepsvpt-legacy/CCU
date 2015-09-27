<?php

namespace App\Http\Middleware;

use Agent;
use App\Ccu\Core\Entity;
use Carbon\Carbon;
use Closure;
use Illuminate\Auth\Guard;
use Illuminate\Contracts\View\Factory as ViewFactory;

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
}
