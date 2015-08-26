<?php

namespace App\Http\Controllers;

use App\Ccu\Website\Information;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HomeController extends Controller
{
    public function home()
    {
        $jsDirectories = ['controllers', 'directives', 'factories'];

        return view('home', compact('jsDirectories'));
    }

    public function information($name)
    {
        if (null === ($info = Information::find($name)))
        {
            throw new NotFoundHttpException;
        }

        return response($info->getAttribute('content'));
    }
}