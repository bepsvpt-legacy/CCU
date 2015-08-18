<?php

namespace App\Http\Middleware;

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

        $this->setGlobalViewVariables();

        $this->response = $next($request);

        return $this->response;
    }

    protected function setGlobalViewVariables()
    {
        $this->view->share('guard', $this->guard);
    }
}