<?php

namespace App\Http\Controllers\Api;

use App\Ccu\General\Category;
use App\Ccu\General\Event;
use App\Ccu\General\Verify;
use App\Ccu\Member\Account;
use App\Ccu\Member\Role;
use App\Events\Member\RegisterEvent;
use App\Events\Member\SignInEvent;
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

        event(new SignInEvent(Auth::user()));

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

        event(new RegisterEvent($account));

        return response()->json(['message' => ['Register success.']]);
    }

    public function verifyEmail($token)
    {
        if ( ! (($account = Verify::verifyToken($token)) instanceof Account))
        {
            return view('errors.emailVerifyFailed', ['message' => $account]);
        }

        $account->attachRole(Role::where('name', '=', 'verified-user')->first());

        Event::create([
            'category_id' => Category::getCategories('events.account', true),
            'account_id' => $account->getAttribute('id'),
            'action' => 'account.verifyEmail',
        ]);

        return redirect()->route('home');
    }

    public function signOut()
    {
        Auth::logout();

        return response()->json(['message' => ['Sing out success.']]);
    }
}