<?php

namespace App\Http\Middleware;

abstract class Middleware
{
    /**
     * Determine if the request has a URI that should pass.
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
