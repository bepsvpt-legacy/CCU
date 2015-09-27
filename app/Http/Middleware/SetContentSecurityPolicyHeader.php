<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SetContentSecurityPolicyHeader extends Middleware
{
    /**
     * The URIs that should be excluded from content security policy.
     *
     * @var array
     */
    protected $except = [
        'assets/*',
        'images/*',
        'logs',
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
        $response = $next($request);

        switch (true) {
            case ($this->shouldPassThrough($request, $this->except)):
            case ($response instanceof BinaryFileResponse):
                return $response;
        }

        $response->header('Content-Security-Policy',
            "style-src *.bepsvpt.net https://cdnjs.cloudflare.com https://maxcdn.bootstrapcdn.com https://fonts.googleapis.com 'unsafe-inline';" .
            "script-src *.bepsvpt.net https://cdnjs.cloudflare.com https://www.google.com https://apis.google.com https://ajax.googleapis.com https://www.gstatic.com https://www.google-analytics.com " .
            "'sha256-H9EpD3T5JFFGDYAqo8gL2yzG+cfJvNN5Bgs6jVowgDc=';" .
            "frame-ancestors 'self'"
        );

        return $response;
    }
}
