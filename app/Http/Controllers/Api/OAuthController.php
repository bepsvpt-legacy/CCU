<?php

namespace App\Http\Controllers\Api;

use App\Ccu\Member\Account;
use App\Exceptions\OAuthException;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class OAuthController extends Controller
{
    public function facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookCallback()
    {
        try {
            $facebook = Socialite::driver('facebook')->scopes(['email'])->user();

            // 確認使用者有提供 Email
            if (null === $facebook->getEmail()) {
                throw new OAuthException;
            }

            // 如果 Email 不存在，創見帳號，如 Email 已存在，則略過此步驟
            if (null === ($account = Account::where('email', '=', $facebook->getEmail())->first(['id']))) {
                $account = Account::create(['email' => $facebook->getEmail(), 'password' => str_random(32)]);

                if ( ! $account->exists) {
                    throw new ModelNotFoundException;
                }

                $account->load(['user'])
                    ->getRelation('user')
                    ->update(['nickname' => $facebook->getName() . '@facebook']);
            }

            \Auth::loginUsingId($account->getAttribute('id'), true);

            return redirect()->route('home');
        } catch (ClientException $e) {
            $data = ['您似乎並未允許本網站存取您的資料', false];
        } catch (InvalidStateException $e) {
            $data = ['似乎出了點狀況，請嘗試重新登入', false];
        } catch (ModelNotFoundException $e) {
            $data = ['網站似乎出了點狀況，請稍候再嘗試', false];
        } catch (OAuthException $e) {
            $data = ['您似乎並未允許本網站存取您的信箱', true];
        } catch (\Exception $e) {
            $data = ['網站似乎出了點狀況，請稍候再嘗試', false];

            \Log::error('Non-catch exception.', ['code' => $e->getCode(), 'message' => $e->getMessage()]);
        }

        return view('errors.oauthFailed', ['message' => $data[0], 'invalidEmail' => $data[1]]);
    }
}
