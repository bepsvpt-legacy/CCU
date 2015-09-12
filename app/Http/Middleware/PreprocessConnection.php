<?php

namespace App\Http\Middleware;

use Agent;
use Carbon\Carbon;
use Closure;
use Illuminate\Auth\Guard;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PreprocessConnection
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

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
        $this->request = $request;

        Carbon::setLocale('zh-TW');

        if (( ! $this->shouldPassThrough($this->request, $this->browserDetectionExcept)) && $this->isBrowserNotSupport()) {
            return redirect()->route('errors.browserNotSupport');
        }

        $this->setGlobalViewVariables();

        $this->response = $next($request);

        return $this->response;
    }

    protected function setGlobalViewVariables()
    {
        $this->view->share('guard', $this->guard);
    }

    /**
     * Determine if the user browser is not support.
     *
     * @return bool
     */
    protected function isBrowserNotSupport()
    {
        if (('IE' === ($browser = Agent::browser())) && (Agent::version($browser) < 11)) {
            return true;
        }

        return false;
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
