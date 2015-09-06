<?php

namespace App\Http\Controllers\Api;

use App\Ccu\Website\Information;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WebsiteController extends Controller
{
    public function information($name)
    {
        if (null === ($info = Information::find($name)))
        {
            throw new NotFoundHttpException;
        }

        return response($info->getAttribute('content'));
    }
}