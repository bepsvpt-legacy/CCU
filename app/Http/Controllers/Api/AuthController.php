<?php

namespace App\Http\Controllers\Api;

use App\Ccu\Member\Account;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function signIn(Request $request)
    {
        if ( ! Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $request->input('rememberMe', false)))
        {
            return response()->json(['message' => ['Invalid email or password.']], 422);
        }

        return response()->json(['message' => ['Sign in success.']]);
    }

    public function register(Requests\RegisterRequest $request)
    {
        $account = Account::create(['email' => $request->input('email'), 'password' => $request->input('password')]);

        if ( ! $account->exists)
        {
            return response()->json(['message' => ['Register failed, please try again later.']], 500);
        }

        Auth::loginUsingId($account->getAttribute('id'), true);

        return response()->json(['message' => ['Register success.']]);
    }

    public function signOut()
    {
        Auth::logout();

        return response()->json(['message' => ['Sing out success.']]);
    }
}