<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use View;

class AssetsController extends Controller
{
    public function styles()
    {
        View::addExtension('css.php', 'php');

        $viewPath = 'css.' . implode('.', func_get_args());

        return $this->getView($viewPath, ['Content-Type' => 'text/css']);
    }

    public function scripts()
    {
        View::addExtension('js.php', 'blade');

        $viewPath = 'js.' . implode('.', func_get_args());

        return $this->getView($viewPath, ['Content-Type' => 'application/javascript; charset=UTF-8']);
    }

    public function templates()
    {
        $viewPath = 'templates.' . implode('.', func_get_args());

        return $this->getView($viewPath);
    }

    public function getView($viewPath, array $headers = [])
    {
        if ( ! View::exists($viewPath))
        {
            throw new NotFoundHttpException;
        }

        return response()->view($viewPath, [], 200, $headers);
    }
}