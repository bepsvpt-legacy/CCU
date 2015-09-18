<?php

namespace App\Http\Controllers;

use App\Ccu\Core\Entity;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $version = Entity::VERSION;

        return view('home', compact('version'));
    }
}
