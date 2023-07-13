<?php

namespace App\Http\Controllers\Auth;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
// use App\User;
use App\Models\RegistrationKey;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected function redirectTo()
    {
        $userType = auth()->user()->user_type_ID;
        switch ($userType) {
            case 1:
                return route('rd.index');
            case 2:
                return route('rpo.index');
            case 3:
                return route('pd.index');
            case 4:
                return route('ppo.dashboard');
            case 5:
                return route('dc.index');
            case 6:
                return route('users.adminView');
            default:
                return '/';
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validator = Validator::make($data, [
            'first_name' => ['required', 'string', 'regex:/^[\pL\s\-]+$/u', 'max:255'],
            'last_name' => ['required', 'string', 'regex:/^[\pL\s\-]+$/u', 'max:255'],
            'middle_name' => ['required', 'string', 'regex:/^[\pL\s\-]+$/u', 'max:255'],
            'birthday' => ['required', 'date'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'user_type_ID' => ['required'],
            'division_ID' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $validator->after(function ($validator) use ($data) {
            
            $existingUserEmail = User::where('email', $data['email'])->first();
            if ($existingUserEmail) {
                $validator->errors()->add('email', 'The email has already been taken.');
            }
            $birthday = Carbon::parse($data['birthday']);
            $minAge = Carbon::now()->subYears(18);
            if ($birthday->greaterThan($minAge)) {
                $validator->errors()->add('birthday', 'You must be at least 18 years old.');
            }
        });

        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $registrationKey = RegistrationKey::where('registration_key', $data['registration_key'])->first();
        $registrationKey->update(['Status' => 'Taken']);

        
        return User::create([
            'username' => $data['first_name'] . '  ' . $data['last_name'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'middle_name' => $data['middle_name'],
            'extension_name' => $data['extension_name'],
            'birthday' => $data['birthday'],
            'email' => $data['email'],
            'user_type_ID' => (int) $data['user_type_ID'],
            'division_ID' => (int) $data['division_ID'] == '0' ? null : (int) $data['division_ID'],
            'province_ID' => (int) $data['province_ID'] == '0' ? null : (int) $data['province_ID'],
            'status' => $data['status'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
