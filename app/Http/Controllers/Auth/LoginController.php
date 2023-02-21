<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

     protected function redirectTo()
     {
        // if (auth()->user()->user_type_ID === 1) {
        //     return route('rd.index');
        // }
        // if (auth()->user()->user_type_ID === 2) {
        //     return route('rpo.index');
        // }
        // if (auth()->user()->user_type_ID === 3) {
        //     return route('pd.index');
        // }
        // if (auth()->user()->user_type_ID === 4) {
        //     return route('ppo.index');
        // }
        // if (auth()->user()->user_type_ID === 5) {
        //     return route('dc.index');
        // }
        // if (auth()->user()->user_type_ID === 6) {
        //      return route('users.adminView');
        // }
        $userType = auth()->user()->user_type_ID;
        switch ($userType) {
            case 1:
                return route('rd.index');
            case 2:
                return route('rpo.index');
            case 3:
                return route('pd.index');
            case 4:
                return route('ppo.index');
            case 5:
                return route('dc.index');
            case 6:
                return route('admin.index');
            default:
                return '/';
        }

       
     }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
