<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $username;
    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);

        // Check if the user exists and their status is not "disabled"
        $user = $this->guard()->getProvider()->retrieveByCredentials($credentials);
        if ($user && $this->guard()->attempt($credentials, $request->filled('remember'))) {
            if ($user->status == 'disabled') {
                $this->guard()->logout();
                throw ValidationException::withMessages([
                    $this->username() => [trans('Account Disabled')],
                ])->redirectTo(route('login'));
            }
            return true;
        }

        return false;
    }
    protected function redirectTo()
    {
        $userType = auth()->user()->user_type_ID;
        $userDetails = auth()->user();
        switch ($userType) {
            case 1:
                return route('rd.index', ['userDetails' => $userDetails]);
            case 2:
                return route('rpo.index', ['userDetails' => $userDetails]);
            case 3:
                return route('pd.index', ['userDetails' => $userDetails]);
            case 4:
                return route('ppo.index', ['userDetails' => $userDetails]);
            case 5:
                return route('dc.index', ['userDetails' => $userDetails]);
            case 6:
                return route('users.adminView', ['userDetails' => $userDetails]);
            default:
                return '/';
        }
    }
    public function findUsername()
    {
        $login = request()->input('login');
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$fieldType => $login]);
        return $fieldType;
    }

    /**
     * Get username property.
     *
     * @return string
     */
    public function username()
    {
        return $this->username;
    }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->username = $this->findUsername();
    }
   
}
