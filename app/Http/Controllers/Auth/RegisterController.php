<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
    protected $redirectTo = '/';

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
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile' => [
                'required',
                'string',
                'regex:/^(?:\+63|09)\d{9}$/', // PH numbers only
                'unique:users'
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'mobile.regex' => 'Mobile number must start with +63 or 09 and be 11 digits long.'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return User
     */
    protected function create(array $data)
    {
        // Normalize mobile number to +63XXXXXXXXXX format
        $mobile = $data['mobile'];

        if (str_starts_with($mobile, '09')) {
            $mobile = '+63' . substr($mobile, 1);
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $mobile,
            'password' => Hash::make($data['password']),
        ]);
    }
}