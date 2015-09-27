<?php

namespace App\Http\Controllers\Api;

use App\Ccu\General\Event;
use App\Ccu\General\Verify;
use App\Ccu\Member\Account;
use App\Ccu\Member\Role;
use App\Events\Member\Register;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ThrottlesLogins;

    /**
     * The number of seconds to delay further login attempts.
     *
     * @var int
     */
    protected $lockoutTime = 300;

    /**
     * The maximum number of login attempts for delaying further attempts.
     *
     * @var int
     */
    protected $maxLoginAttempts = 3;

    /**
     * The login username to be used by the controller.
     *
     * @var string
     */
    protected $username = '';

    /**
     * Handle a sign in request to the application.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signIn(Request $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            return response()->json(['message' => ['IP 位址異常登入，此操作已被拒絕']], 422);
        }

        if ( ! Auth::attempt($request->only(['email', 'password']), $request->input('rememberMe', false))) {
            $this->incrementLoginAttempts($request);

            return response()->json(['message' => ['帳號或密碼錯誤']], 422);
        }

        Event::_create('events.account', Auth::user(), 'account.signIn');

        return response()->json();
    }

    /**
     * Handle a registration request for the application.
     *
     * @param Requests\RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Requests\RegisterRequest $request)
    {
        $account = Account::create($request->only(['email', 'password']));

        if ( ! $account->exists) {
            return response()->json(['message' => ['註冊失敗，請稍候再嘗試']], 500);
        }

        Auth::loginUsingId($account->getAttribute('id'), true);

        event(new Register($account));

        return response()->json();
    }

    /**
     * Handle a verify email request for the application.
     *
     * @param string $token
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function verifyEmail($token)
    {
        if ( ! (($account = Verify::verifyToken($token)) instanceof Account)) {
            return view('errors.emailVerifyFailed', ['message' => $account]);
        }

        $account->attachRole(Role::where('name', '=', 'verified-user')->first());

        Event::_create('events.account', $account, 'account.verifyEmail');

        return redirect()->route('home');
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signOut()
    {
        Auth::logout();

        return response()->json();
    }

    /**
     * Get the user's roles and permissions.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function rolesPermissions()
    {
        $data = ['roles' => [], 'permissions' => [], 'signIn' => ( ! Auth::guest())];

        if ($data['signIn']) {
            $account = Auth::user()->load(['user.profilePicture', 'roles.perms']);

            $data['roles'] = $account->getRelation('roles')->pluck('name');

            foreach ($account->getRelation('roles') as $role) {
                $data['permissions'] += $role->getRelation('perms')->pluck('name')->toArray();
            }

            $data['email'] = $account->getAttribute('email');
            $data['nickname'] = $account->getRelation('user')->getAttribute('nickname');
        }

        return response()->json($data);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return property_exists($this, 'username') ? $this->username : 'email';
    }
}
