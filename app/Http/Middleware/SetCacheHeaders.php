<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\View\View;

class SetCacheHeaders
{
    /**
     * @var array
     */
    protected $cacheContentType = [
        'text/css',
        'application/javascript',
        'text/html',
    ];

    /**
     * @var array
     */
    protected $cacheFilenameExtensions = [
        '.css',
        '.js',
        '.html',
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
        if ( ! app()->environment(['production']))
        {
            return $next($request);
        }

        $requestPath = $request->getPathInfo();

        if (starts_with($requestPath, '/assets/') && ends_with($requestPath, $this->cacheFilenameExtensions))
        {
            config()->set('session.driver', 'array');
        }

        $response = $next($request);

        if ((starts_with($response->headers->get('Content-Type'), $this->cacheContentType)) && ('/' !== $requestPath))
        {
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
        if (($view = $response->getOriginalContent()) instanceof View)
        {
            $stat = stat($view->getPath());

            $response->setCache([
                'etag' => md5("{$stat['ino']}|{$stat['mtime']}|{$stat['size']}"),
                'public' => true
            ]);

            $response->setExpires(Carbon::now()->addDays(7));

            if ((null !== ($etag = $request->headers->get('If-None-Match'))) || (null !== $request->headers->get('If-Modified-Since')))
            {
                $etags = explode('-', $etag, -1);

                $request->headers->set('If-None-Match', (count($etags) ? ($etags[0] . '"') : ($etag)));

                $response->isNotModified($request);
            }
        }
    }
}