<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SetCacheHeaders
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
        $this->request = $request;

        $requestPath = $this->request->getPathInfo();

        if (starts_with($requestPath, '/assets/') && ends_with($requestPath, $this->cacheFilenameExtensions))
        {
            config()->set('session.driver', 'array');
        }

        $this->response = $next($request);

        if ((starts_with($this->response->headers->get('Content-Type'), $this->cacheContentType)) && ('/' !== $requestPath))
        {
            $this->setCacheHeaders();
        }

        return $this->response;
    }

    /**
     * Set cache headers and 304 not modify if needed.
     */
    protected function setCacheHeaders()
    {
        if (($view = $this->response->getOriginalContent()) instanceof View)
        {
            $stat = stat($view->getPath());

            $lastModified = Carbon::createFromTimestamp($stat['mtime'], 'GMT');

            $this->response->setCache([
                'etag' => md5("{$stat['ino']}|{$stat['mtime']}|{$stat['size']}"),
                'last_modified' => $lastModified,
                'max_age' => 86400,
                'public' => true
            ]);

            $this->response->setExpires($lastModified->copy()->subDays(1));

            if ((null !== ($etag = $this->request->headers->get('If-None-Match'))) || (null !== $this->request->headers->get('If-Modified-Since')))
            {
                $etags = explode('-', $etag, -1);

                $this->request->headers->set('If-None-Match', (count($etags) ? ($etags[0] . '"') : ($etag)));

                $this->response->isNotModified($this->request);
            }
        }
    }
}