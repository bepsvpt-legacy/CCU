<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;

class ErrorsController extends Controller
{
    /**
     * Handle calls to missing methods on the controller.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        $view = "errors.{$method}";

        if (View::exists($view)) {
            return view($view);
        }

        return parent::__call($method, $parameters);
    }
}
