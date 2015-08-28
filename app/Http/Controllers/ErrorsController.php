<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ErrorsController extends Controller
{
    public function browserNotSupport()
    {
        return view('errors.browserNotSupport');
    }

    public function noscript()
    {
        return view('errors.noscript');
    }
}