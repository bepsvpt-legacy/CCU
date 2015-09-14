<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\View\View;

class SetCacheHeaders
{
    /**
     * The request path that need cache.
     *
     * @var array
     */
    protected $needCachePath = [
        '/assets',
        '/images',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( ! app()->environment(['production'])) {
            return $next($request);
        }

        $needCache = starts_with($request->getPathInfo(), $this->needCachePath);

        if ($needCache) {
            config()->set('session.driver', 'array');
        }

        $response = $next($request);

        if ($needCache) {
            $this->setCacheHeaders($request, $response);
        }

        return $response;
    }

    /**
     * Set cache headers and 304 not modify if needed.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Http\Response $response
     */
    protected function setCacheHeaders($request, $response)
    {
        if (starts_with($request->getPathInfo(), ['/images'])) {
            $stat = stat(session()->pull('requestImagePath'));
        }
        else if (($view = $response->getOriginalContent()) instanceof View) {
            $stat = stat($view->getPath());
        }

        if (isset($stat)) {
            $response->setCache([
                'etag' => md5("{$stat['ino']}|{$stat['mtime']}|{$stat['size']}"),
                'public' => true
            ]);

            $response->setExpires(Carbon::now()->addDays(30));

            if ((null !== ($etag = $request->headers->get('If-None-Match'))) || (null !== $request->headers->get('If-Modified-Since'))) {
                $etags = explode('-', $etag, -1);

                $request->headers->set('If-None-Match', (count($etags) ? ($etags[0] . '"') : ($etag)));

                $response->isNotModified($request);
            }
        }
    }
}
